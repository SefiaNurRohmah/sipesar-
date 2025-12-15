<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'user_id',
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
        'alamat_tk',
        'kartu_keluarga',
        'akta_kelahiran',
        'foto_3x4',
        'ijazah',
        'ktp_ortu',
        'kartu_bantuan',
        'kartu_keluarga_path',
        'akta_kelahiran_path',
        'foto_3x4_path',
        'ijazah_path',
        'ktp_ortu_path',
        'kartu_bantuan_path',
        'status',
        'notes',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
