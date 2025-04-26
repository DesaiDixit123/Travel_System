<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CorporateAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('corporate')->check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}
