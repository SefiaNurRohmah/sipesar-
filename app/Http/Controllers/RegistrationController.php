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

            // FILE: HANYA PDF/JPG (hapus PNG)
            'kk'            => 'nullable|file|mimes:pdf,jpg,jpeg|max:5120',
            'akta'          => 'nullable|file|mimes:pdf,jpg,jpeg|max:5120',
            'foto'          => 'nullable|file|mimes:jpg,jpeg|max:2048', // Foto 3x4 hanya JPG
            'ijazah'        => 'nullable|file|mimes:pdf,jpg,jpeg|max:5120',
            'ktp_ortu'      => 'nullable|file|mimes:pdf,jpg,jpeg|max:5120',
            'kartu_bantuan' => 'nullable|file|mimes:pdf,jpg,jpeg|max:5120',

            'action' => 'nullable|string|in:save,draft',
        ], [
            'kk.mimes'            => 'Kartu Keluarga hanya boleh PDF/JPG.',
            'akta.mimes'          => 'Akta Kelahiran hanya boleh PDF/JPG.',
            'foto.mimes'          => 'Foto 3x4 hanya boleh JPG.',
            'ijazah.mimes'        => 'Ijazah hanya boleh PDF/JPG.',
            'ktp_ortu.mimes'      => 'KTP Orang Tua hanya boleh PDF/JPG.',
            'kartu_bantuan.mimes' => 'Kartu Bantuan hanya boleh PDF/JPG.',
        ]);

        $action = $request->input('action', 'save');

        // prepare data to save (teks)
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

        // Cek apakah ini pendaftaran baru
        $existing = Registration::firstWhere('user_id', $user->id);

        // Set status hanya untuk pendaftaran baru
        if (!$existing) {
            $data['status'] = 'menunggu keputusan';
        }

        // Buat atau update record utama dulu
        $registration = Registration::updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        // upload map: input => [filename_col, path_col]
        $uploadMap = [
            'kk'            => ['kartu_keluarga', 'kartu_keluarga_path'],
            'akta'          => ['akta_kelahiran', 'akta_kelahiran_path'],
            'foto'          => ['foto_3x4', 'foto_3x4_path'],
            'ijazah'        => ['ijazah', 'ijazah_path'],
            'ktp_ortu'      => ['ktp_ortu', 'ktp_ortu_path'],
            'kartu_bantuan' => ['kartu_bantuan', 'kartu_bantuan_path'],
        ];

        foreach ($uploadMap as $input => [$fileCol, $pathCol]) {
            if ($request->hasFile($input)) {
                $file = $request->file($input);

                $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = strtolower($file->getClientOriginalExtension());

                // aman + rapi
                $filename = time() . '_' . Str::slug($baseName) . '.' . $ext;

                // simpan di storage/app/public/registration/{userId}
                $storedPath = $file->storeAs("registration/{$user->id}", $filename, 'public');

                // hapus file lama jika ada (PAKAI DISK PUBLIC)
                $oldPath = $registration->{$pathCol};
                if (!empty($oldPath) && Storage::disk('public')->exists($oldPath)) {
                    try {
                        Storage::disk('public')->delete($oldPath);
                    } catch (\Throwable $e) {
                        // silent fail
                    }
                }

                // simpan nama file dan path
                $registration->{$fileCol} = $filename;
                $registration->{$pathCol} = $storedPath;
            }
        }

        // OPTIONAL: Anda boleh set status draft kalau ingin
        // Catatan: kalau Anda tidak ingin status berubah ketika update, comment bagian ini.
        if ($action === 'draft') {
            // hanya set draft jika belum diverifikasi (opsional)
            if ($registration->status === 'menunggu keputusan' || $registration->status === 'draft') {
                $registration->status = 'draft';
            }
        } else {
            if ($registration->status === 'draft') {
                $registration->status = 'menunggu keputusan';
            }
        }

        $registration->save();

        $msg = $action === 'draft' ? 'Draft berhasil disimpan.' : 'Perubahan berhasil disimpan.';
        return redirect()->route('siswa.form')->with('status', $msg);
    }

    /**
     * Tampilkan dokumen (open in new tab).
     * $type: 'kk'|'akta'|'foto'|'ijazah'|'ktp_ortu'|'kartu_bantuan'
     */
    public function viewDocument(string $type)
    {
        $user = Auth::user();
        $registration = Registration::firstWhere('user_id', $user->id);
        if (!$registration) {
            abort(404);
        }

        $map = [
            'kk'            => 'kartu_keluarga_path',
            'akta'          => 'akta_kelahiran_path',
            'foto'          => 'foto_3x4_path',
            'ijazah'        => 'ijazah_path',
            'ktp_ortu'      => 'ktp_ortu_path',
            'kartu_bantuan' => 'kartu_bantuan_path',
        ];

        if (!isset($map[$type])) {
            abort(404);
        }

        $path = $registration->{$map[$type]} ?? null;
        if (empty($path)) {
            abort(404);
        }

        // karena upload pakai disk public, cek pakai disk public juga
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $mime = Storage::disk('public')->mimeType($path) ?? 'application/octet-stream';

        // tampilkan inline untuk pdf/jpg
        return response(Storage::disk('public')->get($path), 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }
}
