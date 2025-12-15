<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Registration;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ambil record pendaftaran
        $registration = Registration::firstWhere('user_id', $user->id);

        // gabungkan data form (notes json atau kolom)
        $formData = [];
        if ($registration) {
            if (!empty($registration->notes)) {
                $notes = json_decode($registration->notes, true);
                if (is_array($notes)) $formData = $notes;
            }

            $cols = [
                'nama',
                'nik',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'alamat',
                'nama_ayah',
                'nama_ibu',
                'pekerjaan_ortu',
                'hp_ortu',
                'nama_tk',
                'alamat_tk'
            ];
            foreach ($cols as $c) {
                if (!array_key_exists($c, $formData)) {
                    $formData[$c] = $registration->{$c} ?? null;
                }
            }
        }

        // fields wajib untuk menghitung completion ratio
        $requiredFields = [
            'nama',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'alamat',
            'nama_ayah',
            'nama_ibu',
            'pekerjaan_ortu',
            'hp_ortu',
            'nama_tk',
            'alamat_tk'
        ];

        $filled = 0;
        foreach ($requiredFields as $f) {
            if (!empty(trim((string)($formData[$f] ?? '')))) $filled++;
        }
        $totalFields = count($requiredFields);
        $fieldCompletionRatio = $totalFields ? ($filled / $totalFields) : 0.0;

        // dokumen wajib (5 dokumen @ 20% = 100%)
        $mandatoryDocumentCols = [
            'kartu_keluarga_path',
            'akta_kelahiran_path',
            'foto_3x4_path',
            'ijazah_path',
            'ktp_ortu_path',
        ];

        // dokumen opsional
        $optionalDocumentCols = [
            'kartu_bantuan_path',
        ];

        $mandatoryDocsCount = 0;
        $optionalDocsCount = 0;
        $docStatus = [];

        if ($registration) {
            // cek dokumen wajib
            foreach ($mandatoryDocumentCols as $col) {
                $exists = $this->checkDocumentExists($registration, $col, $user->id);
                $docStatus[$col] = $exists;
                if ($exists) $mandatoryDocsCount++;
            }

            // cek dokumen opsional
            foreach ($optionalDocumentCols as $col) {
                $exists = $this->checkDocumentExists($registration, $col, $user->id);
                $docStatus[$col] = $exists;
                if ($exists) $optionalDocsCount++;
            }
        } else {
            foreach (array_merge($mandatoryDocumentCols, $optionalDocumentCols) as $col) {
                $docStatus[$col] = false;
            }
        }

        // hitung persentase dokumen (5 dokumen wajib @ 20%)
        $docPercent = $mandatoryDocsCount * 20;

        // combine: docs take absolute percent, remaining percent allocated to form fields
        $remaining = max(0, 100 - $docPercent);
        $fieldContribution = (int) round($fieldCompletionRatio * $remaining);
        $progress = min(100, $docPercent + $fieldContribution);

        return view('siswa.dashboard', [
            'user' => $user,
            'registration' => $registration,
            'formData' => $formData,
            'filled' => $filled,
            'totalFields' => $totalFields,
            'mandatoryDocsCount' => $mandatoryDocsCount,
            'optionalDocsCount' => $optionalDocsCount,
            'docStatus' => $docStatus,
            'docPercent' => $docPercent,
            'progress' => $progress,
        ]);
    }


    /**
     * Helper function untuk mengecek apakah dokumen exists
     */
    private function checkDocumentExists($registration, $col, $userId)
    {
        $raw = $registration->{$col} ?? null;
        $exists = false;

        if (!empty($raw)) {
            // inisialisasi kandidat path
            $candidates = [];

            // normalisasi: jika mulai dengan 'public/' hapus untuk pengecekan disk('public')
            $normalized = preg_replace('#^public/#', '', $raw);
            $candidates[] = $normalized;

            // tambahkan raw apa adanya
            $candidates[] = $raw;

            // jika hanya filename, bangun kemungkinan lokasi
            if (!str_contains($raw, '/')) {
                $candidates[] = "registration/{$userId}/{$raw}";
                $candidates[] = "public/registration/{$userId}/{$raw}";
            }

            // juga tambahkan candidate dengan 'private/' prefix
            $candidates[] = 'private/' . ltrim($normalized, '/');
            $candidates[] = 'private/' . ltrim($raw, '/');

            // cek tiap kandidat
            foreach (array_unique($candidates) as $candidate) {
                if (empty($candidate)) continue;

                // cek disk public (relatif ke storage/app/public)
                if (Storage::disk('public')->exists(ltrim($candidate, '/'))) {
                    $exists = true;
                    break;
                }

                // cek absolute path di storage/app/...
                $abs = storage_path('app/' . ltrim($candidate, '/'));
                if (file_exists($abs)) {
                    $exists = true;
                    break;
                }
            }
        }

        return $exists;
    }
}
