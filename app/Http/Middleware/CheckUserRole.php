<?php
// app/Http/Middleware/CheckUserRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user && $user->roles->isNotEmpty() && $user->roles[0]->id == $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}
