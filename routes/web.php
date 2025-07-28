<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\Lantai5Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('guest')->get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    // Dashboard bisa diakses oleh ground dan lantai5
    Route::middleware('role:resepsionis_ground,resepsionis_lantai5')->group(function () {
        Route::get('/dashboard', [TamuController::class, 'dashboard'])->name('dashboard');
    });

    // Fitur form hanya untuk ground
    Route::middleware('role:resepsionis_ground')->group(function () {
        Route::get('/form', [TamuController::class, 'form'])->name('form');
        Route::post('/form', [TamuController::class, 'store'])->name('form.store');

        // Profil user
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // History bisa diakses oleh ground dan lantai5
    Route::middleware('role:resepsionis_ground,resepsionis_lantai5')->group(function () {
        Route::get('/history', [TamuController::class, 'history'])->name('history');
        Route::delete('/history/{id}', [TamuController::class, 'destroy'])->name('history.destroy');
        Route::get('/history/export', [TamuController::class, 'export'])->name('history.export');
        Route::post('/history/keluar/{id}', [TamuController::class, 'keluar'])->name('history.keluar');
    });
});

    Route::middleware(['auth', 'role:resepsionis_lantai5'])->group(function () {
        Route::get('/lantai5/tamu', [TamuController::class, 'lantai5Tamu'])->name('lantai5.tamu');
    });


// Auth routes dari Breeze
require __DIR__.'/auth.php';