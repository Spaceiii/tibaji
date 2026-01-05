<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(empty($cart))
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Votre panier est vide</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par ajouter des articles au panier.</p>
                            <div class="mt-6">
                                <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Parcourir le catalogue
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4 mb-6">
                            @foreach($cart as $key => $item)
                                <div class="flex items-center gap-4 p-4 border rounded-lg">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-24 h-24 object-cover rounded">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $item['type'] === 'weapon' ? 'Arme' : 'Accessoire' }}
                                            @if(isset($item['category']))
                                                - Catégorie {{ $item['category'] }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600">Prix unitaire : {{ number_format($item['price'], 2) }} €</p>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-20 border-gray-300 rounded-md text-center">
                                            <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-sm">Modifier</button>
                                        </form>

                                        <form action="{{ route('cart.remove', $key) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-bold text-xl">{{ number_format($item['price'] * $item['quantity'], 2) }} €</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-medium">Sous-total</span>
                                <span class="text-lg">{{ number_format($total, 2) }} €</span>
                            </div>
                            <div class="flex justify-between items-center text-2xl font-bold">
                                <span>Total</span>
                                <span>{{ number_format($total, 2) }} €</span>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir vider le panier ?')" class="bg-red-100 hover:bg-red-200 text-red-800 font-bold py-3 px-6 rounded-lg transition">
                                    Vider le panier
                                </button>
                            </form>

                            <a href="{{ route('catalog.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                                Continuer mes achats
                            </a>

                            <a href="{{ route('orders.checkout') }}" class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition">
                                Finaliser ma Réservation →
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
