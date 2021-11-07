<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHarga extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobil_id',
        'duration',
        'harga',
    ];

    public function mobil(){
        return $this->belongsTo(MasterMobil::class,'mobil_id');
    }
}
