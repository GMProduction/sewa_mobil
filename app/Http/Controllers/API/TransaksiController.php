<?php

namespace App\Http\Controllers\API;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\MasterHarga;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends CustomController
{
    //
    public function index(){
        if (\request()->isMethod('POST')){
            return $this->store();
        }
        $data = Transaksi::with(['harga.mobil'])->where('user_id','=',Auth::id())->get();
        return $data;
    }

    public function store(){
        \request()->validate([
            'harga' => 'required',
            'tanggal' => 'required',
        ]);
        $harga = MasterHarga::find(\request('harga'));
        $mobilStatus = $harga->mobil->status;
        if ($mobilStatus !== 0){
            return response()->json([
                'message' => 'Mobil tidak tersedia'
            ],201);
        }
        $field = [
            'user_id' => Auth::id(),
            'harga_id' => \request('harga'),
            'total' => $harga->harga,
            'tanggal_pinjam' => \request('tanggal'),
            'status' => 0,
            'status_pembayaran' => 0,
        ];
        Transaksi::create($field);
        return response()->json('berhasil');
    }

    public function show($id){
        $trans = Transaksi::find($id);
        return $trans;
    }

    public function bukti($id){
        $trans = Transaksi::find($id);
        $textImg  = $this->generateImageName('bukti');
        $string   = '/images/bukti/'.$textImg;
        $this->uploadImage('bukti', $textImg, 'bukti');
        $trans->update(['image' => $string]);
        return response()->json('berhasil');

    }
}
