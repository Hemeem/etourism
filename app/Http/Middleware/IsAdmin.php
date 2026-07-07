<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pengecekan: Jika user belum login, atau login tapi rolenya bukan admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak! Anda bukan Administrator.');
        }

        return $next($request);
    }
}