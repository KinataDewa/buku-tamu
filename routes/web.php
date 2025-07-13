<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TamuController;

// Halaman dashboard utama
Route::get('/', [TamuController::class, 'dashboard'])->name('dashboard');

// Halaman form input tamu
Route::get('/form', [TamuController::class, 'form'])->name('form');

// Proses penyimpanan data form
Route::post('/form', [TamuController::class, 'store'])->name('form.store');

// Halaman riwayat tamu
Route::get('/history', [TamuController::class, 'history'])->name('history');

// Hapus History
Route::delete('/history/{id}', [TamuController::class, 'destroy'])->name('history.destroy');

// Route Export Excel
Route::get('/history/export', [TamuController::class, 'export'])->name('history.export');

Route::post('/history/keluar/{id}', [TamuController::class, 'keluar'])->name('history.keluar');


