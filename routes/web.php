<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\Lantai5Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('guest')->get('/', function () {
    return redirect()->route('login');
});

// Redirect setelah login
Route::middleware('auth')->get('/', function () {
    $role = Auth::user()->role;

    if ($role === 'resepsionis_lantai5') {
        return redirect()->route('lantai5.tamu');
    } elseif ($role === 'direksi') {
        return redirect()->route('direksi.tamu');
    } elseif ($role === 'tukarfaktur') {
        return redirect()->route('tukarfaktur.tamu');
    }
    return redirect()->route('dashboard'); // default resepsionis_ground
});

Route::middleware('auth')->group(function () {

    // Dashboard hanya untuk ground
    Route::middleware('role:resepsionis_ground')->group(function () {
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

    // History hanya untuk ground
    Route::middleware('role:resepsionis_ground')->group(function () {
        Route::get('/history', [TamuController::class, 'history'])->name('history');
        Route::delete('/history/{id}', [TamuController::class, 'destroy'])->name('history.destroy');
        Route::get('/history/export', [TamuController::class, 'export'])->name('history.export');
        Route::post('/history/keluar/{id}', [TamuController::class, 'keluar'])->name('history.keluar');
    });
});

// 🔥 Route khusus lantai 5
Route::middleware(['auth', 'role:resepsionis_lantai5'])->group(function () {
    Route::get('/lantai5/tamu', [TamuController::class, 'lantai5Tamu'])->name('lantai5.tamu');
});

// 🔥 Route khusus Direksi
Route::middleware(['auth', 'role:direksi'])->group(function () {
    Route::get('/direksi/tamu', [TamuController::class, 'direksiTamu'])->name('direksi.tamu');
});

// 🔥 Route khusus Tukar Faktur
Route::middleware(['auth', 'role:tukarfaktur'])->group(function () {
    Route::get('/tukarfaktur/tamu', [TamuController::class, 'tukarFakturTamu'])->name('tukarfaktur.tamu');
});


// Auth routes Breeze
require __DIR__.'/auth.php';
