<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Weapon;

class CatalogController extends Controller
{
    public function index()
    {
        $weapons = Weapon::with('weaponType')->get();
        // On pourrait aussi passer les accessoires ici :
        $accessories = Accessory::all();

        return view('catalog.index', compact('weapons'));
    }

    public function show(Weapon $weapon)
    {
        $weapon->load('weaponType');

        return view('catalog.show', compact('weapon'));
    }
}
