<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
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
        if (! $request->user() || ! in_array($request->user()->role, [UserRole::ICT_ADMIN, UserRole::SUPER_ADMIN], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Akses tidak dibenarkan. Hanya pentadbir yang boleh mengakses fungsi ini.',
            ], 403);
        }

        return $next($request);
    }
}
