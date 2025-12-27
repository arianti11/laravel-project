<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsStaff
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan hanya user dengan role 'staff'
     * yang bisa mengakses route yang dilindungi
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')
                           ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah user adalah staff
        if (!auth()->user()->isStaff()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Staff.');
        }

        // Jika lolos semua pengecekan, lanjutkan request
        return $next($request);
    }
}