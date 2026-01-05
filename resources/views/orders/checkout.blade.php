<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finaliser ma réservation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($hasWeapons)
                        <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium">
                                        Votre réservation contient des armes réglementées. Elle devra être validée par un administrateur avant expédition.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h3 class="text-lg font-bold mb-4">Récapitulatif de votre réservation</h3>

                    <div class="space-y-4 mb-6">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-4 p-4 border rounded-lg">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h4 class="font-bold">{{ $item['name'] }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $item['type'] === 'weapon' ? 'Arme' : 'Accessoire' }}
                                        @if(isset($item['category']))
                                            - Catégorie {{ $item['category'] }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600">Quantité : {{ $item['quantity'] }}</p>
                                </div>

                                <div class="text-right">
                                    <p class="font-bold text-lg">{{ number_format($item['price'] * $item['quantity'], 2) }} €</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 mb-6">
                        <div class="flex justify-between items-center text-xl font-bold">
                            <span>Total</span>
                            <span>{{ number_format($total, 2) }} €</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h4 class="font-bold mb-2">Informations de livraison</h4>
                        <p class="text-sm text-gray-600">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf

                        <div class="flex gap-4">
                            <a href="{{ route('cart.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">
                                Retour au panier
                            </a>

                            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition">
                                Confirmer la réservation
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
