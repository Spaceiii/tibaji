<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <--- Indispensable pour gérer les fichiers

class WeaponController extends Controller
{
    // Affiche la liste (Vue Index)
    public function index()
    {
        // On récupère les armes avec leur type pour éviter les requêtes N+1
        $weapons = Weapon::with('weaponType')->get();
        return view('admin.weapons.index', compact('weapons'));
    }

    public function create()
    {
        $types = WeaponType::all(); // Pour le menu déroulant
        return view('admin.weapons.create', compact('types'));
    }

    // Enregistre l'arme en BDD
    public function store(Request $request)
    {
        // 1. Déterminer quel calibre utiliser AVANT la validation
        $caliber = $request->input('caliber_select') === 'custom'
            ? $request->input('caliber_manual')
            : $request->input('caliber_select');

        // On injecte la valeur finale dans la requête pour la valider proprement sous le nom 'caliber'
        $request->merge(['caliber' => $caliber]);

        // 2. Validation
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'weapon_type_id' => 'required|exists:weapon_types,id',
            'caliber' => 'required|string|max:50',
            'category' => 'required|in:B,C,D',
            'serial_number' => 'required|unique:weapons',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        // 3. Gestion de l'image à la création
        if ($request->hasFile('image')) {
            // Stocke dans storage/app/public/weapons et renvoie le chemin
            $path = $request->file('image')->store('weapons', 'public');
            $validated['image'] = $path; // On utilise bien 'image' comme nom de colonne
        }

        Weapon::create($validated);

        return redirect()->route('admin.weapons.index')->with('success', 'Arme créée avec succès.');
    }

    public function edit(Weapon $weapon)
    {
        $types = WeaponType::all();
        return view('admin.weapons.edit', compact('weapon', 'types'));
    }

    public function update(Request $request, Weapon $weapon)
    {
        $caliber = $request->input('caliber_select') === 'custom'
            ? $request->input('caliber_manual')
            : $request->input('caliber_select');

        $request->merge(['caliber' => $caliber]);

        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'weapon_type_id' => 'required|exists:weapon_types,id',
            'caliber' => 'required|string|max:50',
            'category' => 'required|in:B,C,D',
            'serial_number' => 'required|unique:weapons,serial_number,' . $weapon->id,
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($weapon->image) {
                Storage::disk('public')->delete($weapon->image);
            }
            $validated['image'] = $request->file('image')->store('weapons', 'public');
        } else {
            unset($validated['image']);
        }

        $weapon->update($validated);

        return redirect()->route('admin.weapons.index')->with('success', 'Arme mise à jour avec succès.');
    }

    /**
     * Supprime l'arme
     */
    public function destroy(Weapon $weapon)
    {
        if ($weapon->image) {
            Storage::disk('public')->delete($weapon->image);
        }

        $weapon->delete();

        return redirect()->route('admin.weapons.index')->with('success', 'Arme supprimée du stock.');
    }
}
