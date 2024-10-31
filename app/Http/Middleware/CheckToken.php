<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated using Sanctum
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'message' => 'Invalid Token'
            ], 401); // Unauthorized status
        }

        // If the token exists and is valid, proceed with the request
        return $next($request);
    }
}
