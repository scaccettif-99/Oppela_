<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsOwner
{
    public function handle(Request $request, Closure $next)
    {
        $allowedRoles = ['admin', 'owner'];

        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403, 'Non autorizzato.');
        }

        return $next($request);
    }
}