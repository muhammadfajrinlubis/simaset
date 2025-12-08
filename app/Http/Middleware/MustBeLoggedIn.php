<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MustBeLoggedIn
{
    public function handle($request, Closure $next)
    {
        // Jika user belum login
        if (!Auth::check()) {
            return response()->view('errors.forbidden', [], 403);
        }

        return $next($request);
    }
}
