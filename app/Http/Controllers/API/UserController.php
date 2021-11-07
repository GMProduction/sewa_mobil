<?php

namespace App\Http\Controllers\API;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends CustomController
{
    //
    public function index()
    {
        if (\request()->isMethod('POST')) {
            return $this->store();
        }
        $user = User::with('pelanggan')->find(Auth::id());

        return $user;
    }

    public function store()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'password' => 'required|confirmed',
                'nama'     => 'required',

            ]
        );

        $fieldPelanggan = \request()->validate(
            [
                'alamat' => 'required',
                'no_hp'  => 'required',
                'no_ktp' => 'required',
            ]
        );
        $username       = User::where([['username', '=', $field['username']], ['id', '!=', Auth::id()]])->first();
        if ($username) {
            return response()->json(
                [
                    "msg" => "The username has already been taken.",
                ],
                '201'
            );
        }
        Arr::forget($field, 'password');
        if (strpos(request('password'), '*') === false) {
            Arr::set($field, 'password', Hash::make(request('password')));
        }

        if (\request('foto_ktp')){
            $textImg  = $this->generateImageName('foto_ktp');
            $string   = '/images/ktp/'.$textImg;
            $this->uploadImage('foto_ktp', $textImg, 'ktp');
            Arr::set($fieldPelanggan, 'foto_ktp', $string);
        }
        $user = User::find(Auth::id());
        $user->update($field);
        $user->pelanggan()->update($fieldPelanggan);

        return User::with('pelanggan')->find(Auth::id());
    }

    public function avatar(){
        $field = \request()->validate([
           'avatar' => 'required'
        ]);

        $textImg  = $this->generateImageName('avatar');
        $string   = '/images/avatar/'.$textImg;
        $this->uploadImage('avatar', $textImg, 'avatar');
        Arr::set($field, 'avatar', $string);
        $user = User::find(Auth::id());
        $user->pelanggan()->update($field);
        return User::with('pelanggan')->find(Auth::id());

    }

}
