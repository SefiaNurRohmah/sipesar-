<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;

class FormulirPendaftaranController extends Controller
{
    // Menampilkan formulir pendaftaran
    public function index()
    {
        return view('formulirPendaftaran.index');
    }

    // Menyimpan data formulir pendaftaran
    public function store(Request $request)
{
    // Validasi input dari form
    $validated = $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'nik' => 'required|numeric|digits:16',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:L,P',
        'agama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'nama_ayah' => 'required|string|max:255',
        'nama_ibu' => 'required|string|max:255',
        'pekerjaan_orang_tua' => 'required|string|max:255',
        'no_hp_orang_tua' => 'required|numeric',
        'nama_tk' => 'required|string|max:255',
        'alamat_sekolah_asal' => 'required|string|max:255',
        'kk_file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        'akta_kelahiran_file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        'foto_3x4' => 'required|file|mimes:jpg,jpeg,png',
    ]);

    // Proses penyimpanan file jika ada
    $kkFile = $request->file('kk_file')->store('documents');
    $aktaKelahiranFile = $request->file('akta_kelahiran_file')->store('documents');
    $foto3x4 = $request->file('foto_3x4')->store('documents');

    // Simpan data formulir pendaftaran
    $pendaftaran = FormulirPendaftaran::create([
        'nama_lengkap' => $request->nama_lengkap,
        'nik' => $request->nik,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'agama' => $request->agama,
        'alamat' => $request->alamat,
        'nama_ayah' => $request->nama_ayah,
        'nama_ibu' => $request->nama_ibu,
        'pekerjaan_orang_tua' => $request->pekerjaan_orang_tua,
        'no_hp_orang_tua' => $request->no_hp_orang_tua,
        'nama_tk' => $request->nama_tk,
        'alamat_sekolah_asal' => $request->alamat_sekolah_asal,
        'kk_file' => $kkFile,
        'akta_kelahiran_file' => $aktaKelahiranFile,
        'foto_3x4' => $foto3x4,
    ]);

    // Tentukan aksi berdasarkan tombol yang diklik
    if ($request->action == 'submit') {
        // Jika tombol "Simpan Perubahan" diklik
        return redirect()->route('formulirPendaftaran.index')->with('success', 'Formulir pendaftaran berhasil disubmit!');
    } elseif ($request->action == 'draft') {
        // Jika tombol "Simpan Draft" diklik
        return redirect()->route('formulirPendaftaran.index')->with('info', 'Pendaftaran disimpan sebagai draft!');
    }

    // Default, jika ada aksi lain
    return redirect()->route('formulirPendaftaran.index')->with('error', 'Terjadi kesalahan!');
}

}
