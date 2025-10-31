<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IzinSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'siswa_id',
        'nama_siswa',
        'kelas',
        'tanggal_izin',
        'alasan',
        'file',
        'status',
        'catatan',
        'ajukan_izin_id',
    ];
    
    protected $casts = [
        'tanggal_izin' => 'date',
    ];

    protected $dates = ['deleted_at'];

    // 🔹 Relasi ke tabel users (siswa yang mengajukan izin)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // 🔹 Alias tambahan agar tetap kompatibel dengan kode lama
    public function user()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // 🔹 Relasi ke tabel ajukan_izin
    public function ajukanIzin()
    {
        return $this->belongsTo(AjukanIzin::class, 'ajukan_izin_id')->withDefault();
    }
}
