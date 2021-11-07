<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MasterMobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    //
    public function index(){
        $mobil = MasterMobil::with('harga')->get();
        return $mobil;
    }

    public function show($id){
        return MasterMobil::with('harga')->find($id);

    }
}
