<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AjukanIzin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ajukan_izins';

    protected $fillable = [
        'siswa_id',
        'nama_siswa',
        'kelas',
        'tanggal_izin',
        'alasan',
        'file',
        'status',
        'catatan'
    ];  

    protected $dates = ['deleted_at']; // penting untuk soft delete

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // Relasi ke IzinSiswa (gunakan hasMany)
    public function izinSiswa()
    {
        return $this->hasMany(IzinSiswa::class, 'ajukan_izin_id');
    }

    // ❌ Jangan hapus relasi secara permanen, cukup biarkan soft delete
    protected static function booted()
    {
        static::deleting(function ($ajukan) {
            // Kalau soft delete → jangan hapus relasi
            if (! $ajukan->isForceDeleting()) {
                return;
            }

            // Kalau hard delete (force delete) baru hapus relasinya
            $ajukan->izinSiswa()->each(function ($izin) {
                $izin->delete();
            });
        });
    }
}
