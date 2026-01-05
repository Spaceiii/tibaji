<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Weapon;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Afficher toutes les commandes de l'utilisateur
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Afficher le détail d'une commande
     */
    public function show(Order $order)
    {
        // Vérifier que la commande appartient à l'utilisateur
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items');

        return view('orders.show', compact('order'));
    }

    /**
     * Finaliser la commande depuis le panier
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Vérifier le stock et les permissions
        $hasWeapons = false;
        $total = 0;

        foreach ($cart as $item) {
            if ($item['type'] === 'weapon') {
                $hasWeapons = true;
                $weapon = Weapon::find($item['id']);

                if (!$weapon || $weapon->quantity < $item['quantity']) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Stock insuffisant pour ' . $item['name']);
                }
            } else {
                $accessory = Accessory::find($item['id']);
                if (!$accessory || $accessory->quantity < $item['quantity']) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Stock insuffisant pour ' . $item['name']);
                }
            }

            $total += $item['price'] * $item['quantity'];
        }

        return view('orders.checkout', compact('cart', 'total', 'hasWeapons'));
    }

    /**
     * Créer la commande
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            $hasWeapons = false;

            // Créer la commande
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => 0, // Sera calculé après
                'status' => 'pending',
            ]);

            // Créer les items de commande
            foreach ($cart as $item) {
                $order->items()->create([
                    'item_type' => $item['type'],
                    'item_id' => $item['id'],
                    'item_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'category' => $item['category'] ?? null,
                ]);

                if ($item['type'] === 'weapon') {
                    $hasWeapons = true;
                    // Décrémenter le stock
                    $weapon = Weapon::find($item['id']);
                    $weapon->decrement('quantity', $item['quantity']);
                } else {
                    $accessory = Accessory::find($item['id']);
                    $accessory->decrement('quantity', $item['quantity']);
                }

                $total += $item['price'] * $item['quantity'];
            }

            // Mettre à jour le total
            $order->update(['total_amount' => $total]);

            // Vider le panier
            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Votre commande a été créée avec succès ! ' .
                    ($hasWeapons ? 'Elle sera validée par un administrateur avant expédition.' : 'Vous recevrez un email de confirmation.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
            //return redirect()->route('cart.index')
            //    ->with('error', 'Une erreur est survenue lors de la création de la commande.');
        }
    }
}
