<?php

use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\AdminLicenseController;
use App\Http\Controllers\Admin\WeaponController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ProfileController;
use App\Models\Weapon;
use App\Models\Accessory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::get('/', function () {
    $featuredWeapons = Weapon::with('weaponType')
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();

    $featuredAccessories = Accessory::with('accessoryType')
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();

    return view('welcome', compact('featuredWeapons', 'featuredAccessories'));
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/catalogue', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogue/{weapon}', [CatalogController::class, 'show'])->name('catalog.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('weapons', WeaponController::class);
    Route::resource('accessories', AccessoryController::class);
    Route::get('/licenses', [AdminLicenseController::class, 'index'])->name('licenses.index');
    Route::patch('/licenses/{license}/approve', [AdminLicenseController::class, 'approve'])->name('licenses.approve');
    Route::patch('/licenses/{license}/reject', [AdminLicenseController::class, 'reject'])->name('licenses.reject');
    Route::get('/licenses/{license}/download', [AdminLicenseController::class, 'download'])->name('licenses.download');
    
    Route::get('/commandes', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/commandes/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/commandes/{order}/approuver', [AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::patch('/commandes/{order}/refuser', [AdminOrderController::class, 'reject'])->name('orders.reject');
    Route::patch('/commandes/{order}/terminer', [AdminOrderController::class, 'complete'])->name('orders.complete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Afficher la page (GET)
    Route::get('/ma-licence', [LicenseController::class, 'create'])->name('license.create');
    Route::post('/license', [LicenseController::class, 'store'])->name('license.store');
    
    // Cart routes
    Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/panier/{key}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/panier/{key}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/panier', [CartController::class, 'clear'])->name('cart.clear');
    
    Route::get('/mes-commandes', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/commande/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/panier/finaliser', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/commande', [OrderController::class, 'store'])->name('orders.store');
});

require __DIR__.'/auth.php';
