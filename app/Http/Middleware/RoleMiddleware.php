<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Vérifier connexion
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Vérifier rôle
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403); // Accès interdit
        }

        // 3. Autoriser
        return $next($request);
    }
}
