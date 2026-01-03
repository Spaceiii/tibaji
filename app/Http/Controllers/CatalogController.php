<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Weapon;

class CatalogController extends Controller
{
    public function index()
    {
        $weapons = Weapon::with('weaponType')->get();
        $accessories = Accessory::with('accessoryType')->get();

        return view('catalog.index', compact('weapons', 'accessories'));
    }

    public function show(Weapon $weapon)
    {
        $weapon->load('weaponType');

        return view('catalog.show', compact('weapon'));
    }
}
