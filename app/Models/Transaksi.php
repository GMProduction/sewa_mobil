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
        'total',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'status_pembayaran',
        'image',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function harga()
    {
        return $this->belongsTo(MasterHarga::class, 'harga_id');
    }

    public function scopeStatus($query, $filter)
    {
        $query->when(
            $filter ?? false,
            function ($query, $filter) {
                if ($filter == '11'){
                    return $query->where('status_pembayaran','=',$filter);
                }
                return $query->where('status', '=', $filter);
            }
        );
    }
}
