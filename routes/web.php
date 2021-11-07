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

Route::prefix('/')->middleware(\App\Http\Middleware\Authenticate::class)->group(
    function () {

        Route::get(
            '/',
            function () {
                return view('admin.dashboard');
            }
        );

//    Route::get('/', function () {
//        return view('admin');
//    });

        Route::match(['POST', 'GET'], 'user', [\App\Http\Controllers\Admin\UserController::class, 'index']);

        Route::prefix('mobil')->group(
            function () {
                Route::match(['POST', 'GET'], '/', [\App\Http\Controllers\Admin\MobilController::class, 'index']);
                Route::get('{id}/delete', [\App\Http\Controllers\Admin\MobilController::class, 'delete']);
                Route::match(['POST', 'GET'], 'harga/{id}', [\App\Http\Controllers\Admin\MobilController::class, 'getHarga']);
                Route::get('harga/{id}/delete', [\App\Http\Controllers\Admin\MobilController::class, 'deleteHarga']);
            }
        );

        Route::prefix('transaksi')->group(
            function () {
                Route::get('/', [\App\Http\Controllers\Admin\TransaksiController::class, 'index']);
                Route::get('/{id}', [\App\Http\Controllers\Admin\TransaksiController::class, 'getTransaksiId']);
                Route::post('/{id}/konfirmasi-bayar', [\App\Http\Controllers\Admin\TransaksiController::class, 'konfirmasiBayar']);
                Route::post('/{id}/sewa', [\App\Http\Controllers\Admin\TransaksiController::class, 'sewa']);
            }
        );

        Route::prefix('laporantransaksi')->group(
            function () {
                Route::get('/', [\App\Http\Controllers\Admin\TransaksiController::class, 'laporanTransaksi']);
                Route::get('/cetak', [\App\Http\Controllers\Admin\TransaksiController::class, 'cetak']);

            }
        );

        Route::prefix('laporanpemasukan')->group(
            function () {
                Route::get('/', [\App\Http\Controllers\Admin\PemasukanController::class, 'index']);
                Route::get('/cetak', [\App\Http\Controllers\Admin\PemasukanController::class, 'cetak']);
            }
        );

        Route::get('/cetaklaporantransaksi', [LaporanController::class, 'cetakLaporanTransaksi']);
        Route::get('/cetaklaporanpendapatan', [LaporanController::class, 'cetakLaporanPemasukan']);

    }
);

Route::post('/login', [AuthController::class, 'loginWeb'])->name('login');
Route::get(
    '/login',
    function () {
        return view('login');
    }
);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register-member', [AuthController::class, 'registerMember']);
