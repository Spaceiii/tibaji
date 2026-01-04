<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $cart = $this->getCart();
        
        // Debug: voir ce qui est dans le panier
        \Log::info('Cart content in index:', ['cart' => $cart, 'count' => count($cart)]);
        
        $total = $this->calculateTotal($cart);
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request)
    {
        \Log::info('=== ADD TO CART CALLED ===', [
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role ?? 'guest',
            'request_data' => $request->all()
        ]);

        $request->validate([
            'type' => 'required|in:weapon,accessory',
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $type = $request->type;
        $id = $request->id;
        $quantity = $request->quantity;

        // Get the item
        if ($type === 'weapon') {
            $item = Weapon::with('weaponType')->findOrFail($id);
            
            // Check if user has valid license for this weapon
            if (auth()->check()) {
                $hasValidLicense = auth()->user()->license()
                    ->where('status', 'approved')
                    ->where('level', $item->category)
                    ->where('expiration_date', '>', now())
                    ->exists();
                
                if (!$hasValidLicense) {
                    return back()->with('error', 'Vous devez avoir un permis valide de catégorie ' . $item->category . ' pour ajouter cette arme au panier.');
                }
            } else {
                return redirect()->route('login')->with('error', 'Vous devez être connecté pour ajouter une arme au panier.');
            }
        } else {
            $item = Accessory::with('accessoryType')->findOrFail($id);
        }

        // Check stock
        if ($item->quantity < $quantity) {
            return back()->with('error', 'Stock insuffisant pour cet article.');
        }

        // Get current cart
        $cart = $this->getCart();

        // Check if item already exists in cart
        $key = $type . '_' . $id;
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'type' => $type,
                'id' => $id,
                'name' => $type === 'weapon' ? $item->model : $item->name,
                'price' => $item->price,
                'quantity' => $quantity,
                'image' => $item->image,
                'category' => $type === 'weapon' ? $item->weaponType->name : $item->accessoryType->name,
            ];
        }

        // Save cart to session
        Session::put('cart', $cart);

        // Debug: verify cart was saved
        $savedCart = Session::get('cart', []);
        \Log::info('Cart after adding item:', ['cart' => $savedCart, 'count' => count($savedCart)]);

        return back()->with('success', 'Article ajouté au panier avec succès.');
    }

    /**
     * Update item quantity in cart.
     */
    public function update(Request $request, $key)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();

        if (!isset($cart[$key])) {
            return back()->with('error', 'Article introuvable dans le panier.');
        }

        $cart[$key]['quantity'] = $request->quantity;
        Session::put('cart', $cart);

        return back()->with('success', 'Quantité mise à jour.');
    }

    /**
     * Remove an item from cart.
     */
    public function remove($key)
    {
        $cart = $this->getCart();

        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('cart', $cart);
            return back()->with('success', 'Article retiré du panier.');
        }

        return back()->with('error', 'Article introuvable dans le panier.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Panier vidé.');
    }

    /**
     * Get cart from session.
     */
    private function getCart()
    {
        return Session::get('cart', []);
    }

    /**
     * Calculate cart total.
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Get cart item count.
     */
    public static function getCartCount()
    {
        $cart = Session::get('cart', []);
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
}
