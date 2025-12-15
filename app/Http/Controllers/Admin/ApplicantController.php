<?php

namespace App\Http\Controllers\Admin;

use App\Events\RegistrationStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Registration;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $statusFilter = $request->status; // ← filter status

        $query = Registration::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nama_tk', 'like', "%{$search}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$search}%");
            });
        }

        // Filter Gender
        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        // Filter Rentang Tanggal: start_date, end_date, or range
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            // If both provided, filter between start and end (inclusive)
            $query->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->paginate(15)->withQueryString();
        $total = Registration::count();

        return view('admin.data_calonsiswa', compact('registrations', 'total'));
    }

    public function show($id)
    {
        $registration = Registration::with('user')->findOrFail($id);

        // Hitung jumlah dokumen wajib yang sudah diupload
        $mandatoryDocs = ['kartu_keluarga_path', 'akta_kelahiran_path', 'foto_3x4_path', 'ijazah_path', 'ktp_ortu_path'];

        $docCompletionCount = 0;
        foreach ($mandatoryDocs as $doc) {
            if (!empty($registration->{$doc})) {
                $docCompletionCount++;
            }
        }

        return view('admin.keloladetailcalonsiswa', compact('registration', 'docCompletionCount'));
    }

    public function viewDocument($id, $type)
    {
        $registration = Registration::findOrFail($id);

        $map = [
            'kk' => 'kartu_keluarga_path',
            'akta' => 'akta_kelahiran_path',
            'foto' => 'foto_3x4_path',
            'ijazah' => 'ijazah_path',
            'ktp_ortu' => 'ktp_ortu_path',
            'kartu_bantuan' => 'kartu_bantuan_path',
        ];

        if (!array_key_exists($type, $map)) {
            abort(404);
        }

        $raw = $registration->{$map[$type]} ?? null;
        if (empty($raw)) {
            abort(404);
        }

        $candidates = [];
        $normalized = preg_replace('#^public/#', '', $raw);
        $candidates[] = $normalized;
        $candidates[] = $raw;
        $candidates[] = "registration/{$registration->user_id}/{$raw}";
        $candidates[] = "public/registration/{$registration->user_id}/{$raw}";
        $candidates[] = "private/{$normalized}";
        $candidates[] = "private/{$raw}";
        $candidates = array_unique(array_filter($candidates));

        $found = null;
        foreach ($candidates as $candidate) {
            $publicAbs = storage_path('app/public/' . ltrim($candidate, '/'));
            if (file_exists($publicAbs)) {
                $found = $publicAbs;
                break;
            }

            $abs = storage_path('app/' . ltrim($candidate, '/'));
            if (file_exists($abs)) {
                $found = $abs;
                break;
            }
        }

        if (!$found) {
            abort(404);
        }

        $mime = @mime_content_type($found) ?: 'application/octet-stream';
        return Response::file($found, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($found) . '"',
        ]);
    }

    /**
     * Tampilkan form verifikasi untuk id.
     */
    public function verifyForm($id)
    {
        $registration = Registration::with('user')->findOrFail($id);
        return view('admin.verifikasi_calonsiswa', compact('registration'));
    }

    /**
     * Simpan hasil verifikasi (status + notes).
     */
    public function updateVerification(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:menunggu keputusan,diterima,tidak diterima',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $registration->status = $request->input('status');
        $registration->notes = $request->input('notes');
        $registration->verified_by = auth()->id();
        $registration->verified_at = now();
        $registration->save();

        // Log the activity
        $adminName = auth()->user()->name;
        $description = "Admin '{$adminName}' mengubah status pendaftaran '{$registration->nama}' menjadi '{$registration->status}'";
        ActivityLog::log('verification', $description, $registration);

        // Dispatch event RegistrationStatusUpdated
        RegistrationStatusUpdated::dispatch($registration);

        return redirect()->route('admin.data')->with('success', 'Status verifikasi berhasil disimpan.');
    }
}
