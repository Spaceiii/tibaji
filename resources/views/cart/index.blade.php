<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-md shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(empty($cart))
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Votre panier est vide</h3>
                        <p class="text-gray-600 mb-6">Découvrez nos armes et accessoires pour commencer vos achats</p>
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg transform hover:-translate-y-0.5 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                            </svg>
                            Retour au catalogue
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 p-4">
                                <h3 class="text-lg font-bold text-white">Articles dans votre panier ({{ count($cart) }})</h3>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($cart as $key => $item)
                                    <div class="p-6 hover:bg-gray-50 transition">
                                        <div class="flex gap-4">
                                            <!-- Image -->
                                            <div class="flex-shrink-0">
                                                @if($item['image'])
                                                    @if(str_starts_with($item['image'], 'http'))
                                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-24 w-24 object-cover rounded-lg shadow-md">
                                                    @else
                                                        <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="h-24 w-24 object-cover rounded-lg shadow-md">
                                                    @endif
                                                @else
                                                    <div class="h-24 w-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Details -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $item['name'] }}</h4>
                                                <p class="text-sm text-gray-500 mb-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item['type'] === 'weapon' ? 'bg-indigo-100 text-indigo-800' : 'bg-emerald-100 text-emerald-800' }}">
                                                        {{ $item['category'] }}
                                                    </span>
                                                </p>
                                                <p class="text-2xl font-bold text-indigo-600">{{ number_format($item['price'], 2, ',', ' ') }} €</p>
                                            </div>

                                            <!-- Quantity & Actions -->
                                            <div class="flex flex-col items-end justify-between">
                                                <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>

                                                <div class="flex items-center gap-2">
                                                    <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center focus:ring-indigo-500 focus:border-indigo-500">
                                                        <button type="submit" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition">
                                                            Mettre à jour
                                                        </button>
                                                    </form>
                                                </div>

                                                <p class="text-sm text-gray-600 mt-2">
                                                    Sous-total: <span class="font-bold text-gray-900">{{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }} €</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between">
                            <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                </svg>
                                Continuer mes achats
                            </a>

                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir vider votre panier ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-md transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Vider le panier
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden sticky top-24">
                            <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 p-4">
                                <h3 class="text-lg font-bold text-white">Récapitulatif</h3>
                            </div>
                            
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between text-gray-600">
                                    <span>Sous-total</span>
                                    <span class="font-semibold">{{ number_format($total, 2, ',', ' ') }} €</span>
                                </div>
                                
                                <div class="flex justify-between text-gray-600">
                                    <span>TVA (20%)</span>
                                    <span class="font-semibold">{{ number_format($total * 0.20, 2, ',', ' ') }} €</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between text-xl font-bold text-gray-900">
                                        <span>Total TTC</span>
                                        <span class="text-indigo-600">{{ number_format($total * 1.20, 2, ',', ' ') }} €</span>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <a href="#" class="block w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white text-center font-bold rounded-lg shadow-lg transform hover:-translate-y-0.5 transition">
                                        Valider ma commande
                                    </a>
                                </div>

                                <div class="text-xs text-gray-500 text-center pt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Paiement sécurisé
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
