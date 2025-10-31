<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanKalender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'catatan',
        'kategori', 
        'role',
        'user_id',
    ];
}
