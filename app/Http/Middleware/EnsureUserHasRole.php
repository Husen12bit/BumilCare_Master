<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Cek apakah user yang login memiliki salah satu role yang diizinkan.
     * Contoh pemakaian: ->middleware('role:nakes') atau 'role:nakes,bumil'
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $userRole = $user->role?->value;

        if (! in_array($userRole, $roles, true)) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
