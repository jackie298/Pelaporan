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
        if (!auth()->check()) {
            abort(403, 'Akses ditolak');
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (!$user->isAdmin()) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
