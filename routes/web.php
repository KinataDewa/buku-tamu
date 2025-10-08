<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\Lantai5Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventGuestController;

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
    } elseif ($role === 'event') {
        return redirect()->route('events.index'); // ✅ Tambahan baru
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

// Route khusus lantai 5
Route::middleware(['auth', 'role:resepsionis_lantai5'])->group(function () {
    Route::get('/lantai5/tamu', [TamuController::class, 'lantai5Tamu'])->name('lantai5.tamu');
});

// Route khusus Direksi
Route::middleware(['auth', 'role:direksi'])->group(function () {
    Route::get('/direksi/tamu', [TamuController::class, 'direksiTamu'])->name('direksi.tamu');
});

// Route khusus Tukar Faktur
Route::middleware(['auth', 'role:tukarfaktur'])->group(function () {
    Route::get('/tukarfaktur/tamu', [TamuController::class, 'tukarFakturTamu'])->name('tukarfaktur.tamu');
});

Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/create', [EventController::class, 'create'])->name('create');
    Route::post('/', [EventController::class, 'store'])->name('store');

    // Daftar tamu
    Route::get('/{event}/guests', [EventController::class, 'guests'])->name('guests');

    // Import & Export Excel
    Route::post('/{event}/guests/import', [EventController::class, 'importGuests'])->name('guests.import');
    Route::get('/{event}/guests/export', [EventController::class, 'exportGuests'])->name('guests.export');

    // Tambah tamu manual
    Route::get('/{event}/guests/create', [EventController::class, 'createGuest'])->name('guests.create');
    Route::post('/{event}/guests/store', [EventController::class, 'storeGuest'])->name('guests.store');

    // Kehadiran tamu
    Route::post('/{event}/guests/{guest}/attendance', [EventController::class, 'markAttendance'])->name('guests.attendance');
});



// Auth routes Breeze
require __DIR__.'/auth.php';
