<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil user login
        $user = Auth::user();

        // Cek apakah role user adalah 'Admin'
        if ($user->role !== 'Admin') {
            abort(403, 'Akses ditolak — hanya Admin yang boleh mengakses halaman ini.');
        }

        return $next($request);
    }
}
