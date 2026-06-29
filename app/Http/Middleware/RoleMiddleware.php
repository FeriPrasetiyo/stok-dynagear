<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (! $user) {
            return redirect('/login');
        }

        if (! in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke aplikasi Stock.');
        }

        return $next($request);
    }
}