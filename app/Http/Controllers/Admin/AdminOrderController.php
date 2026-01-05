<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Liste de toutes les commandes
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Filtrer par statut si demandé
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'pending' => Order::where('status', 'pending')->count(),
            'approved' => Order::where('status', 'approved')->count(),
            'rejected' => Order::where('status', 'rejected')->count(),
            'completed' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Afficher le détail d'une commande
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items', 'user.license']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Approuver une commande
     */
    public function approve(Order $order)
    {
        $order->update([
            'status' => 'approved',
            'approved_at' => now(),
            'admin_comment' => null,
        ]);

        return redirect()->back()->with('success', 'Commande approuvée avec succès.');
    }

    /**
     * Refuser une commande
     */
    public function reject(Request $request, Order $order)
    {
        $request->validate([
            'admin_comment' => 'required|string|max:1000',
        ]);

        $order->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'admin_comment' => $request->admin_comment,
        ]);

        return redirect()->back()->with('success', 'Commande refusée.');
    }

    /**
     * Marquer une commande comme terminée
     */
    public function complete(Order $order)
    {
        $order->update([
            'status' => 'completed',
        ]);

        return redirect()->back()->with('success', 'Commande marquée comme terminée.');
    }
}
