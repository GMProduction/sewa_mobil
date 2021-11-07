<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    //

    public function index(){
        $data = Transaksi::with(['user','harga.mobil'])->status(\request('status'))->paginate(10);
        return view('admin.transaksi')->with(['data' => $data]);
    }

    public function getTransaksiId($id){
        return Transaksi::with(['user.pelanggan','harga.mobil'])->find($id);
    }

    public function konfirmasiBayar($id){
        $trans = Transaksi::find($id);
        $trans->update(['status_pembayaran' => \request('status')]);
        if (\request('status') == '2'){
            $trans->update(['status' => 1]);
            $trans->harga->mobil()->update(['status' => 1]);
        }
        return response()->json('berhasil');
    }

    public function sewa($id){
        $trans = Transaksi::find($id);
        $trans->update(['status' => \request('status')]);
        if (\request('status') == '3'){
            $trans->update(['tanggal_kembali' => now('Asia/Jakarta')]);
            $trans->harga->mobil()->update(['status' => 0]);
        }elseif (\request('status') == '2'){
            $trans->harga->mobil()->update(['status' => 2]);
        }
        return response()->json('berhasil');
    }

    public function laporanTransaksi(){
        $data = Transaksi::with(['user','harga.mobil'])->status(\request('status'));
        if (\request('start')){
            $start = date('Y-m-d', strtotime(\request('start')));
            $end = date('Y-m-d', strtotime(\request('end')));
            $data->whereBetween('tanggal_pinjam',[$start,$end]);
        }
        $data = $data->paginate(10);

        return view('admin.laporantransaksi')->with(['data' => $data]);

    }

    public function cetak()
    {
//        return $this->dataTransaksi();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataTransaksi())->setPaper('f4', 'landscape');

        return $pdf->stream();
    }

    public function dataTransaksi()
    {
        $data = Transaksi::with(['user','harga.mobil'])->status(\request('status'));
        if (\request('start')){
            $start = date('Y-m-d', strtotime(\request('start')));
            $end = date('Y-m-d', strtotime(\request('end')));
            $data->whereBetween('tanggal_pinjam',[$start,$end]);
        }
        $data = $data->get();

        $data   = [
            'data' => $data,
            'start' => \request('start'),
            'end' => \request('end'),
        ];

        return view('admin/cetaktransaksi')->with($data);
    }

}
