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
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
    $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user(); // Ambil data user yang login

    // Cek peran (role) pengguna
    if ($user->role === 'admin') {
        // Jika role adalah 'admin', arahkan ke dashboard admin
        return redirect()->route('admin.dashboard');
    }

    // Jika bukan admin (pengguna biasa), arahkan ke halaman katalog
    return redirect()->route('katalog.index');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}