<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\MasterMobil;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MobilController extends CustomController
{
    //

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(){
        if (\request()->isMethod('POST')){
            return $this->store();
        }
        $data = MasterMobil::paginate(10);
        return view('admin.mobil')->with(['data' => $data]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(){
        $field = \request()->validate([
            'nama' => 'required',
            'tahun' => 'required',
            'keterangan' => 'required',
            'no_pol' => 'required',
        ]);

        if (\request('id')){

        }else{
            $fieldImg = \request()->validate([
                'image' => 'required',
            ]);
            $textImg = $this->generateImageName('image');
            $string = '/images/mobil/'.$textImg;
            $this->uploadImage('image', $textImg, 'mobil');
            Arr::set($field,'image', $string);
            MasterMobil::create($field);
        }
        return response()->json('berhasil');
    }
}
