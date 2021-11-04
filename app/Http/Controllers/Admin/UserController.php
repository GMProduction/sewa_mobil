<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(){
        if (\request()->isMethod('POST')){
            return  $this->store();
        }
        $user = User::with('pelanggan')->paginate(10);
        return view('admin.user')->with(['data' => $user]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(){
        $user = User::find(\request('id'));
        $user->pelanggan()->update(['isActive' => \request('isActive')]);
        return response()->json('berhasil');
    }
}
