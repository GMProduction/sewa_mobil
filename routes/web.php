<?php


use App\Http\Controllers\LaporanController;

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/')->group(function (){

    Route::get('/', function () {
        return view('admin.dashboard');
    });

//    Route::get('/', function () {
//        return view('admin');
//    });

    Route::match(['POST', 'GET'],'user', [\App\Http\Controllers\Admin\UserController::class,'index']);

    Route::match(['POST','GET'],'/mobil', [\App\Http\Controllers\Admin\MobilController::class,'index']);

    Route::get('/transaksi', function () {
        return view('admin.transaksi');
    });

    Route::get('/laporantransaksi', function () {
        return view('admin.laporantransaksi');
    });

    Route::get('/laporanpemasukan', function () {
        return view('admin.laporanpemasukan');
    });


    Route::get('/cetaklaporantransaksi', [LaporanController::class, 'cetakLaporanTransaksi']);
    Route::get('/cetaklaporanpendapatan', [LaporanController::class, 'cetakLaporanPemasukan']);

});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-member', [AuthController::class, 'registerMember']);
