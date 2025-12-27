<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminOrStaff
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan hanya user dengan role 'admin' atau 'staff'
     * yang bisa mengakses route yang dilindungi
     *
     * Cocok untuk route yang bisa diakses admin & staff
     * (misalnya: view products, view orders, dll)
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

        // Cek apakah user adalah admin atau staff
        if (!auth()->user()->isAdminOrStaff()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin dan Staff.');
        }

        // Jika lolos semua pengecekan, lanjutkan request
        return $next($request);
    }
}