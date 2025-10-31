<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Kalau user buka halaman register
            if ($request->is('register') || $request->is('register/*')) {
                return redirect()->route('dashboard')->with('success', 'Anda sudah daftar');
            }

            // Kalau user buka halaman login
            if ($request->is('login') || $request->is('login/*')) {
                return redirect()->route('dashboard')->with('success', 'Anda sudah login');
            }

            // Kalau bukan halaman login/register, tetap lanjut
            return $next($request);
        }

        return $next($request);
    }
}
