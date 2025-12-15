<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class KepalaSekolahController extends Controller
{
    public function dashboard()
    {
        $totalRegistrations = Registration::count();
        $acceptedRegistrations = Registration::where('status', 'diterima')->count();
        $rejectedRegistrations = Registration::where('status', 'ditolak')->count();
        $pendingRegistrations = Registration::where('status', 'menunggu keputusan')->count();

        $lolosPercent = $totalRegistrations > 0 ? round(($acceptedRegistrations / $totalRegistrations) * 100, 2) : 0;

        $stats = [
            'total' => $totalRegistrations,
            'lolos' => $acceptedRegistrations,
            'ditolak' => $rejectedRegistrations,
            'menunggu' => $pendingRegistrations,
            'lolos_percent' => $lolosPercent,
        ];

        $recentRegistrations = Registration::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('kepala-sekolah.dashboard', compact('stats', 'recentRegistrations'));
    }

    public function calonSiswa()
    {
        $calonSiswa = Registration::with('user')->get();
        return view('kepala-sekolah.calon-siswa', compact('calonSiswa'));
    }

    public function showCalonSiswa($id)
    {
        $registration = Registration::with('user')->findOrFail($id);
        return view('kepala-sekolah.calon-siswa-detail', compact('registration'));
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
        if (!array_key_exists($type, $map) || empty($registration->{$map[$type]})) {
            abort(404);
        }
        $path = storage_path('app/public/' . $registration->{$map[$type]});
        if (!file_exists($path)) {
            abort(404);
        }
        return Response::file($path);
    }

    public function hasilVerifikasi()
    {
        $verifikasi = Registration::with('user')->whereIn('status', ['diterima', 'ditolak'])->get();
        return view('kepala-sekolah.hasil-verifikasi', compact('verifikasi'));
    }

    public function laporan(Request $request)
    {
        $registrations = $this->getFilteredRegistrations($request);

        $totalPendaftar = Registration::count();
        $diterima = Registration::where('status', 'diterima')->count();
        $menunggu = Registration::where('status', 'menunggu keputusan')->count();
        $ditolak = Registration::where('status', 'tidak diterima')->count();

        $mingguIni = Registration::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $mingguLalu = Registration::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
        $perubahanMinggu = $mingguIni - $mingguLalu;

        $chartData = ['Okt' => 0, 'Nov' => 0, 'Des' => 0, 'Jan' => 0, 'Feb' => 0, 'Mar' => 0];
        $monthlyData = Registration::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->whereIn(DB::raw('MONTH(created_at)'), [10, 11, 12, 1, 2, 3])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        foreach ($monthlyData as $item) {
            $monthName = date('M', mktime(0, 0, 0, $item->bulan, 10));
            if (array_key_exists(ucfirst($monthName), $chartData)) {
                $chartData[ucfirst($monthName)] = $item->jumlah;
            }
        }

        return view('kepala-sekolah.laporan', compact('registrations', 'totalPendaftar', 'diterima', 'menunggu', 'ditolak', 'perubahanMinggu', 'chartData'));
    }

    public function exportPDF(Request $request)
    {
        $registrations = $this->getFilteredRegistrations($request);
        $pdf = Pdf::loadView('kepala-sekolah.reports-pdf', compact('registrations'))->setPaper('A4', 'portrait');
        return $pdf->download('laporan-pendaftaran-siswa-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $registrations = $this->getFilteredRegistrations($request);
        $filename = 'laporan-pendaftaran-siswa-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xef) . chr(0xbb) . chr(0xbf));
            fputcsv($file, ['No', 'Nama Lengkap', 'NIK', 'Asal TK', 'Status', 'Tanggal Daftar']);

            foreach ($registrations as $index => $reg) {
                $status = match ($reg->status) {
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak',
                    'tidak diterima' => 'Ditolak',
                    'menunggu keputusan' => 'Menunggu',
                    default => 'Menunggu',
                };
                fputcsv($file, [$index + 1, $reg->nama ?? '-', $reg->nik ?? '-', $reg->nama_tk ?? '-', $status, $reg->created_at ? $reg->created_at->format('d M Y') : '-']);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getFilteredRegistrations(Request $request)
    {
        $query = Registration::query();

        if ($request->filled('periode')) {
            switch ($request->periode) {
                case 'Harian':
                    $query->whereDate('created_at', today());
                    break;
                case 'Mingguan':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'Bulanan':
                    $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                    break;
            }
        }

        if ($request->filled('status')) {
            $statusMap = [
                'Menunggu' => 'menunggu keputusan',
                'Diterima' => 'diterima',
                'Ditolak' => 'tidak diterima',
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
