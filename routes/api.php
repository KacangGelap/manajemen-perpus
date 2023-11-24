<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\anggotaController;
use App\Http\Controllers\bukuController;
use App\Http\Controllers\notaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('anggota',anggotaController::class);
route::get('anggota/{id}',[anggotaController::class,'show']);
Route::post('anggota/store',[anggotaController::class,'store']);
Route::put('anggota/update/{id}',[anggotaController::class,'update']);
Route::delete('anggota/delete/{id}',[anggotaController::class,'destroy']);
Route::resource('buku',bukuController::class);
Route::post('buku/store',[bukuController::class,'store']);
Route::put('buku/update/{isbn}',[bukuController::class,'update']);
Route::delete('buku/delete/{isbn}',[bukuController::class,'destroy']);
Route::resource('nota',notaController::class);
Route::post('nota/store',[notaController::class,'store']);
Route::put('nota/update/{id}',[notaController::class,'update']);
Route::delete('nota/delete/{id}',[notaController::class,'destroy']);