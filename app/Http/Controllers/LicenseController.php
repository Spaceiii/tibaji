<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;
use Illuminate\Support\Facades\Auth;

class LicenseController extends Controller
{
    public function create()
    {
        // On passe la licence actuelle à la vue (peut être null)
        return view('license.create', [
            'license' => Auth::user()->license
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string|max:255',
            'expiration_date' => 'required|date|after:today', // Doit être valide
            'level' => 'required|string|in:B,C,D', // Adapte selon tes catégories
            'license_file' => 'required|file|mimes:jpg,png,pdf|max:4096',
        ]);

        $path = $request->file('license_file')->store('licenses', 'public');

        License::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'license_number' => $request->license_number,
                'expiration_date' => $request->expiration_date,
                'level' => $request->level,
                'file_path' => $path,
                'status' => 'pending',
                'submitted_at' => now(),
                'verified_at' => null,   // reset validation si re-upload
                'admin_comment' => null,
            ]
        );

        return redirect()->route('license.create')->with('status', 'license-uploaded');
    }
}
