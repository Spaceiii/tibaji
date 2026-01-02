<?php

use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\WeaponController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use App\Models\Weapon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredWeapons = Weapon::with('weaponType')
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();
    return view('welcome', compact('featuredWeapons'));
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/catalogue', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogue/{weapon}', [CatalogController::class, 'show'])->name('catalog.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('weapons', WeaponController::class);
//    Route::resource('accessories', AccessoryController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
