<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMobil extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'tahun',
        'keterangan',
        'image',
        'no_pol',
    ];
}
