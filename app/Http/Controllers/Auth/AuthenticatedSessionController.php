<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user->role;

        // 🔽 Logika redirect sesuai role
        if ($role === 'resepsionis_lantai5') {
            return redirect()->route('lantai5.tamu');
        } elseif ($role === 'direksi') {
            return redirect()->route('direksi.tamu');
        } elseif ($role === 'tukarfaktur') {
            return redirect()->route('tukarfaktur.tamu');
        } elseif ($role === 'event') {
            return redirect()->route('events.index'); // ✅ tambahan event
        } else {
            return redirect()->route('dashboard'); // default resepsionis_ground
        }
    }

    /**
     * Logout user
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
