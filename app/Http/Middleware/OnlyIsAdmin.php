<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->method() !== 'GET' && !auth()->user()?->is_admin) {
            return response()->json([
                'message' => 'Unauthorized (You must be an admin to perform this action).',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
