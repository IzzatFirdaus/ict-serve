<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->hasRole(['ict_admin', 'super_admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Akses tidak dibenarkan. Hanya pentadbir yang boleh mengakses fungsi ini.',
            ], 403);
        }

        return $next($request);
    }
}
