<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'nama'     => 'required',
                'password' => 'required|confirmed',
            ]
        );

        $pelanggan = \request()->validate(
            [
                'no_hp'  => 'required',
                'alamat' => 'required',
            ]
        );
        Arr::set($field, 'roles', 'pelanggan');
        Arr::set($field, 'password', Hash::make($field['password']));
        $user = User::create($field);
        $user->pelanggan()->create($pelanggan);
        $token = $user->createToken('pelanggan')->plainTextToken;
        $user->update(['token' => $token]);
        $data = User::with('pelanggan')->find($user->id);

        return response()->json(
            [
                'status' => 200,
                'data'   => $data,
            ]
        );
    }

    public function login()
    {
        $field = \request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        $user = User::where('username', '=', $field['username'])->first();
        if ( ! $user || ! Hash::check($field['password'], $user->password) || $user->roles != 'pelanggan') {
            return response()->json(
                [
                    'msg' => 'Login gagal',
                ],
                401
            );
        } else {
            $user->tokens()->delete();
            $token = $user->createToken('pelanggan')->plainTextToken;
            $user->update(
                [
                    'token' => $token,
                ]
            );

            return response()->json(
                [
                    'status' => 200,
                    'data'   => [
                        'token' => $token,
                    ],
                ]
            );
        }
    }
}
