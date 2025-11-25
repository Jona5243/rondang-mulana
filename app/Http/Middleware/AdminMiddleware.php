<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\UserRole; 
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN INI

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ganti 'auth()' menjadi 'Auth::'
        if (Auth::check() && Auth::user()->role === UserRole::ADMIN) {
            return $next($request);
        }

        return redirect(route('dashboard'));
    }
}