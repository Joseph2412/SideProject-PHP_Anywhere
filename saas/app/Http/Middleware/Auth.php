<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
       public function handle(Request $request, Closure $next, string $role = null): Response
    {
        $user = $request->user();

        if ($role && $user->role !== $role) {
            abort(403, "Forbidden: You do not have the required role to access this resource.");
        }
        return $next($request);
    }
}
