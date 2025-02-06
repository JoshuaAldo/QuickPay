<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsNotVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect('/product'); // Redirect jika sudah verifikasi
        }

        return $next($request);
    }
}
