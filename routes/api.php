<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('user')->group(function (){
        Route::match(['POST','GET'],'', [\App\Http\Controllers\API\UserController::class, 'index']);
        Route::post('/avatar',[\App\Http\Controllers\API\UserController::class,'avatar']);
    });

    Route::prefix('mobil')->group(function (){
        Route::get('', [\App\Http\Controllers\API\MobilController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\API\MobilController::class, 'show']);
    });
    Route::prefix('transaksi')->group(function (){
        Route::match(['POST','GET'],'',[\App\Http\Controllers\API\TransaksiController::class,'index']);
        Route::get('/{id}',[\App\Http\Controllers\API\TransaksiController::class,'show']);
        Route::post('/{id}/bukti',[\App\Http\Controllers\API\TransaksiController::class,'bukti']);
    });
});


Route::post('register',[\App\Http\Controllers\AuthController::class,'register']);
Route::post('login',[\App\Http\Controllers\AuthController::class,'login']);
