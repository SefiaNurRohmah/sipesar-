<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index()
    {
        // Ambil pengumuman yang statusnya aktif, urutkan dari terbaru
        $pengumuman = Announcement::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.pengumuman', compact('pengumuman'));
    }
}