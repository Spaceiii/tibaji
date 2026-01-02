<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Http\Request;

class WeaponController extends Controller
{
    // Affiche la liste (Vue Index)
    public function index()
    {
        // On récupère les armes avec leur type pour éviter les requêtes N+1
        $weapons = Weapon::with('type')->get();
        return view('admin.weapons.index', compact('weapons'));
    }

    // Affiche le formulaire (Vue Create)
    public function create()
    {
        $types = WeaponType::all(); // Pour le menu déroulant
        return view('admin.weapons.create', compact('types'));
    }

    // Enregistre l'arme en BDD
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'weapon_type_id' => 'required|exists:weapon_types,id',
            'caliber' => 'required|string',
            'category' => 'required|in:B,C,D',
            'serial_number' => 'required|unique:weapons',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        Weapon::create($validated);

        return redirect()->route('admin.weapons.index')->with('success', 'Arme ajoutée au stock.');
    }

    //Méthodes edit, etc...
}
