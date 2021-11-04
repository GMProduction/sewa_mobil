<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'harga_id',
        'durasi',
        'harga',
        'total',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'status_pembayaran',
        'image',
    ];
}
