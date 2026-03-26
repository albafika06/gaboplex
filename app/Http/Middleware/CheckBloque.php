<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBloque
{
    public function handle(Request $request, Closure $next)
    {
        // Ne pas intercepter la route de déblocage
        if ($request->routeIs('contact.bloque')) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->bloque) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                             ->with('compte_bloque', true);
        }

        return $next($request);
    }
}