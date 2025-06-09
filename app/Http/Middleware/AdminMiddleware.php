<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login DAN perannya adalah 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request); // Jika ya, lanjutkan
        }

        // Jika tidak, kembalikan ke halaman utama
        return redirect('/');
    }
}