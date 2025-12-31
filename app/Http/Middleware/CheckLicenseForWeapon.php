<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLicenseForWeapon
{
    /**
     * Handle an incoming request.
     *
     * Vérifie que l'utilisateur possède un permis valide et approuvé
     * pour la catégorie d'arme qu'il tente d'acheter.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer la catégorie d'arme depuis la requête
        $weaponCategory = $request->input('weapon_category') ?? $request->route('weapon_category');

        // Si pas de catégorie spécifiée, laisser passer (sera géré par le controller)
        if (!$weaponCategory) {
            return $next($request);
        }

        // Vérifier que l'utilisateur est authentifié
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour acheter une arme.');
        }

        $user = auth()->user();

        // Les admins peuvent passer (pour gérer le stock)
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Vérifier que l'utilisateur a un permis valide pour cette catégorie
        $hasValidLicense = $user->licenses()
            ->where('level', $weaponCategory)
            ->where('status', 'approved')
            ->where('expiration_date', '>', now())
            ->exists();

        if (!$hasValidLicense) {
            return redirect()->back()
                ->with('error', "Vous devez posséder un permis de catégorie {$weaponCategory} valide et approuvé pour acheter cette arme.");
        }

        return $next($request);
    }
}
