<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik.
     */
    public function index()
    {
        $total = Registration::count();

        // Sesuaikan dengan status di database: diterima, tidak diterima, menunggu keputusan
        $lolos = Registration::where('status', 'diterima')->count();
        $ditolak = Registration::where('status', 'tidak diterima')->count();
        $menunggu = Registration::where('status', 'menunggu keputusan')->count();

        $stats = [
            'total' => $total,
            'lolos' => $lolos,
            'ditolak' => $ditolak,
            'menunggu' => $menunggu,
            'lolos_percent' => $total > 0 ? round($lolos / $total * 100, 1) : 0,
            'ditolak_percent' => $total > 0 ? round($ditolak / $total * 100, 1) : 0,
            'menunggu_percent' => $total > 0 ? round($menunggu / $total * 100, 1) : 0,
        ];

        // Ambil 10 pendaftar terbaru
        $recentRegistrations = Registration::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations'));
    }

    /**
     * Menampilkan halaman log aktivitas.
     */
    public function activityLogs()
    {
        $activities = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.activity-logs', compact('activities'));
    }
}
