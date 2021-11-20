<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    //

    public function index()
    {
        $data = Transaksi::with(['user', 'harga.mobil'])->where('status', '=', 3);
        if (\request('start')) {
            $start = date('Y-m-d', strtotime(\request('start')));
            $end   = date('Y-m-d', strtotime(\request('end')));
            $data->whereBetween('tanggal_pinjam', [$start, $end]);
        }
        $data = $data->paginate(10);

        return view('admin.laporanpemasukan')->with(['data' => $data]);
    }

    public function cetak()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataTransaksi())->setPaper('f4', 'landscape');

        return $pdf->stream();
    }

    public function dataTransaksi()
    {
        $data = Transaksi::with(['user', 'harga.mobil'])->where('status','=', 3);
        if (\request('start')) {
            $start = date('Y-m-d', strtotime(\request('start')));
            $end   = date('Y-m-d', strtotime(\request('end')));
            $data->whereBetween('tanggal_pinjam', [$start, $end]);
        }
        $data = $data->get();
        $data = [
            'data'  => $data,
            'start' => \request('start'),
            'end'   => \request('end'),
            'total' => $data->sum('total')
        ];
        return view('admin/cetakpemasukan')->with($data);
    }
}
