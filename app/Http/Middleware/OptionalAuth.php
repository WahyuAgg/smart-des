<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Optional Authentication Middleware
 * 
 * Allows both authenticated and guest users to access the route.
 * If a valid token is present, the user will be authenticated.
 * If no token or invalid token, the request continues as guest (no 401 error).
 */
class OptionalAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Attempt to authenticate using Sanctum if token is present
        // This will set the authenticated user if token is valid
        // But won't throw 401 if token is missing or invalid
        if ($request->bearerToken()) {
            $request->user();
        }

        return $next($request);
    }
}
