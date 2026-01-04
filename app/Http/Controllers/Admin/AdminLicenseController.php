<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLicenseController extends Controller
{
    public function index()
    {
        $licenses = License::with('user')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->latest('submitted_at')
            ->get();

        return view('admin.licenses.index', compact('licenses'));
    }

    public function download(License $license)
    {
        return Storage::disk('public')->download($license->file_path);
    }

    public function approve(License $license)
    {
        $license->update([
            'status' => 'approved',
            'verified_at' => now(),
            'admin_comment' => null
        ]);

        return back()->with('success', 'Licence validée avec succès.');
    }

    public function reject(Request $request, License $license)
    {
        $license->update([
            'status' => 'rejected',
            'verified_at' => now(),
            'admin_comment' => $request->input('admin_comment', 'Document non conforme.')
        ]);

        return back()->with('error', 'Licence refusée.');
    }
}
