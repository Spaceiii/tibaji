<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté et s'il a le rôle 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Sinon, redirection vers l'accueil avec une erreur 403
        abort(403, 'Accès réservé aux armuriers.');
    }
}
