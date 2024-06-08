<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;

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

Route::prefix('jenis-barang')->group(function () {
   Route::get('/', [JenisBarangController::class, 'index'])->name('list');
   Route::post('/', [JenisBarangController::class, 'store'])->name('store');
   Route::put('/{id}', [JenisBarangController::class, 'update'])->name('update');
   Route::delete('/{id}', [JenisBarangController::class, 'destroy'])->name('destroy');
});

Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('list');
    Route::post('/', [BarangController::class, 'store'])->name('store');
    Route::put('/{id}', [BarangController::class, 'update'])->name('update');
    Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
});

Route::prefix('transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('list');
    Route::get('/compare', [TransaksiController::class, 'compare'])->name('compare');
    Route::post('/', [TransaksiController::class, 'store'])->name('store');
    Route::put('/{id}', [TransaksiController::class, 'update'])->name('update');
    Route::delete('/{id}', [TransaksiController::class, 'destroy'])->name('destroy');
});
