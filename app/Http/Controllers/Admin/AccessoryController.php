<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\AccessoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessories = Accessory::with('accessoryType')->get();
        return view('admin.accessories.index', compact('accessories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = AccessoryType::all();
        return view('admin.accessories.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'accessory_type_id' => 'required|exists:accessory_types,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('accessories', 'public');
        }

        Accessory::create($validated);

        return redirect()->route('admin.accessories.index')->with('success', 'Accessoire créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Accessory $accessory)
    {
        $accessory->load('accessoryType');
        return view('admin.accessories.show', compact('accessory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accessory $accessory)
    {
        $types = AccessoryType::all();
        return view('admin.accessories.edit', compact('accessory', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accessory $accessory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'accessory_type_id' => 'required|exists:accessory_types,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($accessory->image) {
                Storage::disk('public')->delete($accessory->image);
            }
            $validated['image'] = $request->file('image')->store('accessories', 'public');
        } else {
            unset($validated['image']);
        }

        $accessory->update($validated);

        return redirect()->route('admin.accessories.index')->with('success', 'Accessoire mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accessory $accessory)
    {
        if ($accessory->image) {
            Storage::disk('public')->delete($accessory->image);
        }

        $accessory->delete();

        return redirect()->route('admin.accessories.index')->with('success', 'Accessoire supprimé du stock.');
    }
}

