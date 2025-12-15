<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulirPendaftaran extends Model
{
    use HasFactory;
    public function index()
    {
        return view('formulirPendaftaran.index');
    }

    // Tentukan nama tabel yang sesuai dengan yang ada di database
    protected $table = 'formulir_pendaftaran'; // Pastikan sesuai dengan nama tabel di DB

    // Tentukan kolom yang dapat diisi (fillable) untuk menghindari Mass Assignment
    protected $fillable = ['nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'alamat', 'nama_ayah', 'nama_ibu', 'pekerjaan_orang_tua', 'no_hp_orang_tua', 'nama_tk', 'alamat_sekolah_asal', 'kk_file', 'akta_kelahiran_file', 'foto_3x4'];

    // Jika tabel tidak menggunakan timestamps (created_at, updated_at), matikan fitur timestamps
    public $timestamps = false; // Hapus atau sesuaikan dengan tabel jika ada created_at dan updated_at

    // Jika kolom tertentu perlu tipe data spesifik, kamu bisa mendefinisikan cast.
    protected $casts = [
        'tanggal_lahir' => 'date', // Ubah tipe data kolom 'tanggal_lahir' menjadi date
    ];
}
