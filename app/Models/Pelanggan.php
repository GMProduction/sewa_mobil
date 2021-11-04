<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'alamat',
        'no_hp',
        'no_ktp',
        'foto_ktp',
        'avatar',
        'user_id',
        'isActive'
    ];
}
