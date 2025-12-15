<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Query dasar
            $query = Registration::query();

            // Filter berdasarkan periode
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

            // Filter berdasarkan status - SESUAI DATABASE YANG BENAR
            if ($request->filled('status')) {
                // Mapping dari filter ke status database
                $statusMap = [
                    'Menunggu' => 'menunggu keputusan',
                    'Diterima' => 'diterima',
                    'Ditolak' => 'tidak diterima', // DIPERBAIKI: di database adalah 'tidak diterima'
                ];

                if (isset($statusMap[$request->status])) {
                    $query->where('status', $statusMap[$request->status]);
                }
            }

            // Filter berdasarkan tanggal atau rentang tanggal
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $singleDate = $request->input('tanggal');

            if ($startDate && $endDate) {
                $query->whereDate('created_at', '>=', $startDate)
                      ->whereDate('created_at', '<=', $endDate);
            } elseif ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            } elseif ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            } elseif ($singleDate) {
                // Keep backward compatibility with single 'tanggal' param
                $query->whereDate('created_at', $singleDate);
            }

            // Ambil data dengan urutan terbaru
            $registrations = $query->orderBy('created_at', 'desc')->get();

            // Hitung statistik - DIPERBAIKI sesuai dengan status di database
            $totalPendaftar = Registration::count();
            $diterima = Registration::where('status', 'diterima')->count();
            $menunggu = Registration::where('status', 'menunggu keputusan')->count();
            $ditolak = Registration::where('status', 'tidak diterima')->count();

            // Statistik perubahan minggu ini vs minggu lalu
            $mingguIni = Registration::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

            $mingguLalu = Registration::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();

            $perubahanMinggu = $mingguIni - $mingguLalu;

            // Chart Bulanan Oktober → Maret
            $chartData = [
                'Okt' => 0,
                'Nov' => 0,
                'Des' => 0,
                'Jan' => 0,
                'Feb' => 0,
                'Mar' => 0,
            ];

            $monthlyData = Registration::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as jumlah'))
                ->whereIn(DB::raw('MONTH(created_at)'), [10, 11, 12, 1, 2, 3])
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get();

            // Isi ke dalam chartData sesuai bulan
            foreach ($monthlyData as $item) {
                switch ($item->bulan) {
                    case 10:
                        $chartData['Okt'] = $item->jumlah;
                        break;
                    case 11:
                        $chartData['Nov'] = $item->jumlah;
                        break;
                    case 12:
                        $chartData['Des'] = $item->jumlah;
                        break;
                    case 1:
                        $chartData['Jan'] = $item->jumlah;
                        break;
                    case 2:
                        $chartData['Feb'] = $item->jumlah;
                        break;
                    case 3:
                        $chartData['Mar'] = $item->jumlah;
                        break;
                }
            }

            return view('admin.laporan', compact('registrations', 'totalPendaftar', 'diterima', 'menunggu', 'ditolak', 'perubahanMinggu', 'chartData'));
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error di AdminLaporanController: ' . $e->getMessage());

            // Jika terjadi error, return dengan data kosong
            return view('admin.laporan', [
                'registrations' => collect([]),
                'totalPendaftar' => 0,
                'diterima' => 0,
                'menunggu' => 0,
                'ditolak' => 0,
                'perubahanMinggu' => 0,
                'chartData' => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0],
            ])->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    public function exportPDF(Request $request)
    {
        try {
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
                    'Ditolak' => 'tidak diterima', // ✔ FIX
                ];

                if (isset($statusMap[$request->status])) {
                    $query->where('status', $statusMap[$request->status]);
                }
            }

            if ($request->filled('start_date') || $request->filled('end_date') || $request->filled('tanggal')) {
                $s = $request->input('start_date');
                $e = $request->input('end_date');
                $t = $request->input('tanggal');
                if ($s && $e) {
                    $query->whereDate('created_at', '>=', $s)->whereDate('created_at', '<=', $e);
                } elseif ($s) {
                    $query->whereDate('created_at', '>=', $s);
                } elseif ($e) {
                    $query->whereDate('created_at', '<=', $e);
                } elseif ($t) {
                    $query->whereDate('created_at', $t);
                }
            }

            $registrations = $query->orderBy('created_at', 'desc')->get();

            $totalPendaftar = $registrations->count();
            $diterima = $registrations->where('status', 'diterima')->count();
            $menunggu = $registrations->where('status', 'menunggu keputusan')->count();
            $ditolak = $registrations->where('status', 'tidak diterima')->count(); // ✔ FIX

            // Generate PDF
            $pdf = Pdf::loadView('admin.reports-pdf', compact('registrations', 'totalPendaftar', 'diterima', 'menunggu', 'ditolak'))->setPaper('A4', 'portrait'); // ✔ FIX

            return $pdf->download('laporan-spsb-' . date('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('Error export PDF: ' . $e->getMessage());
            return back()->with('error', 'Gagal export PDF: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            // Query dengan filter yang sama
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

            if ($request->filled('start_date') || $request->filled('end_date') || $request->filled('tanggal')) {
                $s = $request->input('start_date');
                $e = $request->input('end_date');
                $t = $request->input('tanggal');
                if ($s && $e) {
                    $query->whereDate('created_at', '>=', $s)->whereDate('created_at', '<=', $e);
                } elseif ($s) {
                    $query->whereDate('created_at', '>=', $s);
                } elseif ($e) {
                    $query->whereDate('created_at', '<=', $e);
                } elseif ($t) {
                    $query->whereDate('created_at', $t);
                }
            }

            $registrations = $query->orderBy('created_at', 'desc')->get();

            // Buat file CSV
            $filename = 'laporan-ppdb-' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($registrations) {
                $file = fopen('php://output', 'w');

                // BOM untuk UTF-8
                fprintf($file, chr(0xef) . chr(0xbb) . chr(0xbf));

                // Header CSV
                fputcsv($file, ['No', 'Nama Lengkap', 'NIK', 'Asal TK', 'Status', 'Tanggal Daftar']);

                // Data
                foreach ($registrations as $index => $reg) {
                    // Mapping status dari database ke tampilan
                    $status = match ($reg->status) {
                        'diterima' => 'Diterima',
                        'tidak diterima' => 'Ditolak',
                        'menunggu keputusan' => 'Menunggu',
                        default => 'Menunggu',
                    };

                    fputcsv($file, [$index + 1, $reg->nama ?? '-', $reg->nik ?? '-', $reg->nama_tk ?? '-', $status, $reg->created_at ? $reg->created_at->format('d M Y') : '-']);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('Error export Excel: ' . $e->getMessage());
            return back()->with('error', 'Gagal export Excel: ' . $e->getMessage());
        }
    }
}
