<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détail de la commande') }} {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $order->order_number }}</h3>
                            <p class="text-gray-600">Réservation passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-bold {{ $order->getStatusBadgeClass() }}">
                            {{ $order->getStatusLabel() }}
                        </span>
                    </div>

                    @if($order->status === 'pending' && $order->hasWeapons())
                        <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-400 text-blue-700">
                            <p class="font-medium">Votre Réservation est en attente de validation.</p>
                            <p class="text-sm mt-1">Elle sera examinée par un administrateur dans les plus brefs délais.</p>
                        </div>
                    @endif

                    @if($order->status === 'approved')
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
                            <p class="font-medium">Votre Réservation a été approuvée !</p>
                            <p class="text-sm mt-1">Elle sera préparée et expédiée prochainement.</p>
                        </div>
                    @endif

                    @if($order->status === 'rejected')
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 text-red-700">
                            <p class="font-medium">Votre Réservation a été refusée.</p>
                            @if($order->admin_comment)
                                <p class="text-sm mt-2">Raison : {{ $order->admin_comment }}</p>
                            @endif
                        </div>
                    @endif

                    <h4 class="font-bold text-lg mb-4">Articles commandés</h4>

                    <div class="space-y-4 mb-6">
                        @foreach($order->items as $item)
                            <div class="flex gap-4 p-4 border rounded-lg">
                                <div class="flex-1">
                                    <h5 class="font-bold">{{ $item->item_name }}</h5>
                                    <p class="text-sm text-gray-600">
                                        {{ $item->item_type === 'weapon' ? 'Arme' : 'Accessoire' }}
                                        @if($item->category)
                                            - Catégorie {{ $item->category }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600">Quantité : {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-600">Prix unitaire : {{ number_format($item->price, 2) }} €</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold">{{ number_format($item->getSubtotal(), 2) }} €</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 mb-6">
                        <div class="flex justify-between items-center text-xl font-bold">
                            <span>Total</span>
                            <span>{{ number_format($order->total_amount, 2) }} €</span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('orders.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                            ← Retour à mes Réservation
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
