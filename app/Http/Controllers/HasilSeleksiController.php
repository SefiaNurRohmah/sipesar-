<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;

class HasilSeleksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $registration = Registration::firstWhere('user_id', $user->id);

        // fallback values
        $name = $registration->nama ?? ($user->name ?? 'Peserta');
        $regNo = $registration && $registration->id ? 'SPSB' . str_pad($registration->id, 6, '0', STR_PAD_LEFT) : '-';

        // map status -> kelas css / teks
        $statusKey = $registration->status ?? 'menunggu keputusan';

        if ($statusKey === 'diterima') {
            $statusClass = 'status-accepted';
            $statusText = 'SELAMAT, ANDA DITERIMA!';
            $statusDesc = 'Selamat! Anda telah diterima di SD Negeri Larangan melalui SIPESAR.';
        } elseif ($statusKey === 'tidak diterima') {
            $statusClass = 'status-rejected';
            $statusText = 'MAAF, ANDA TIDAK DITERIMA';
            $statusDesc = 'Mohon maaf, Anda belum berhasil dalam seleksi kali ini. Tetap semangat!';
        } else {
            // Default: menunggu keputusan
            $statusClass = 'status-pending';
            $statusText = 'MENUNGGU KEPUTUSAN';
            $statusDesc = 'Status pendaftaran Anda sedang menunggu verifikasi dari admin.';
        }

        return view('siswa.hasil_seleksi', compact('user', 'registration', 'name', 'regNo', 'statusKey', 'statusClass', 'statusText', 'statusDesc'));
    }

}
