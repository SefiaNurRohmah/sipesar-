<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Registration;
use Illuminate\Support\Facades\Response;

class RegistrationController extends Controller
{
    // Tampilkan form pendaftaran (GET)
    public function show()
    {
        $user = Auth::user();
        $registration = Registration::firstWhere('user_id', $user->id);

        $formData = $registration ? $registration->toArray() : [];

        return view('siswa.form_pendaftaran', [
            'formData' => $formData,
            'registration' => $registration,
        ]);
    }

    // Simpan / update form pendaftaran (POST)
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:2',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ortu' => 'nullable|string|max:255',
            'hp_ortu' => 'nullable|string|max:30',
            'nama_tk' => 'nullable|string|max:255',
            'alamat_tk' => 'nullable|string|max:500',
            // files
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'akta' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'ktp_ortu' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'kartu_bantuan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'action' => 'nullable|string|in:save,draft',
        ]);

        $action = $request->input('action', 'save');

        // prepare data to save
        $data = [
            'nama' => $validated['nama'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'agama' => $validated['agama'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'nama_ayah' => $validated['nama_ayah'] ?? null,
            'nama_ibu' => $validated['nama_ibu'] ?? null,
            'pekerjaan_ortu' => $validated['pekerjaan_ortu'] ?? null,
            'hp_ortu' => $validated['hp_ortu'] ?? null,
            'nama_tk' => $validated['nama_tk'] ?? null,
            'alamat_tk' => $validated['alamat_tk'] ?? null,
        ];

        // Cek apakah ini pendaftaran baru atau update
        $registration = Registration::firstWhere('user_id', $user->id);

        // Set status hanya untuk pendaftaran baru
        if (!$registration) {
            $data['status'] = 'menunggu keputusan'; // default status untuk pendaftaran baru
        }
        // Jika sudah ada, status tidak diubah (tetap sesuai keputusan admin)

        $registration = Registration::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // upload map: input => [filename_col, path_col]
        $uploadMap = [
            'kk' => ['kartu_keluarga', 'kartu_keluarga_path'],
            'akta' => ['akta_kelahiran', 'akta_kelahiran_path'],
            'foto' => ['foto_3x4', 'foto_3x4_path'],
            'ijazah' => ['ijazah', 'ijazah_path'],
            'ktp_ortu' => ['ktp_ortu', 'ktp_ortu_path'],
            'kartu_bantuan' => ['kartu_bantuan', 'kartu_bantuan_path'],
        ];

        foreach ($uploadMap as $input => [$fileCol, $pathCol]) {
            if ($request->hasFile($input)) {
                $file = $request->file($input);
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $storedPath = $file->storeAs("registration/{$user->id}", $filename, 'public');

                // hapus file lama jika ada
                if (!empty($registration->{$pathCol}) && Storage::exists($registration->{$pathCol})) {
                    try {
                        Storage::delete($registration->{$pathCol});
                    } catch (\Throwable $e) {
                        // silent fail
                    }
                }

                // simpan nama file dan path
                $registration->{$fileCol} = $filename;
                $registration->{$pathCol} = $storedPath;
            }
        }

        $registration->save();

        $msg = $action === 'draft' ? 'Draft berhasil disimpan.' : 'Perubahan berhasil disimpan.';
        return redirect()->route('siswa.form')->with('status', $msg);
    }

    /**
     * Tampilkan dokumen (open in new tab). $type: 'kk'|'akta'|'foto'|'ijazah'|'ktp_ortu'|'kartu_bantuan'
     */
    public function viewDocument(string $type)
    {
        $user = Auth::user();
        $registration = Registration::firstWhere('user_id', $user->id);
        if (! $registration) {
            abort(404);
        }

        $map = [
            'kk' => 'kartu_keluarga_path',
            'akta' => 'akta_kelahiran_path',
            'foto' => 'foto_3x4_path',
            'ijazah' => 'ijazah_path',
            'ktp_ortu' => 'ktp_ortu_path',
            'kartu_bantuan' => 'kartu_bantuan_path',
        ];

        if (! array_key_exists($type, $map)) {
            abort(404);
        }

        $raw = $registration->{$map[$type]} ?? null;
        if (empty($raw)) {
            abort(404);
        }

        // candidates untuk cek lokasi file
        $candidates = [];
        $normalized = preg_replace('#^public/#', '', $raw);
        $candidates[] = $normalized;
        $candidates[] = $raw;
        $candidates[] = "registration/{$user->id}/{$raw}";
        $candidates[] = "public/registration/{$user->id}/{$raw}";
        $candidates[] = "private/{$normalized}";
        $candidates[] = "private/{$raw}";
        $candidates = array_unique(array_filter($candidates));

        $found = null;
        foreach ($candidates as $candidate) {
            // cek storage/app/public (disk public)
            $publicAbs = storage_path('app/public/' . ltrim($candidate, '/'));
            if (file_exists($publicAbs)) {
                $found = $publicAbs;
                break;
            }

            // cek storage/app/...
            $abs = storage_path('app/' . ltrim($candidate, '/'));
            if (file_exists($abs)) {
                $found = $abs;
                break;
            }
        }

        if (! $found) {
            abort(404);
        }

        $mime = @mime_content_type($found) ?: 'application/octet-stream';
        return Response::file($found, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($found) . '"'
        ]);
    }
}
