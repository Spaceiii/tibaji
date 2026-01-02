<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catalogue Armurerie') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-8 px-4">
                <h3 class="text-2xl font-bold text-gray-900 border-l-4 border-indigo-600 pl-4">
                    Nos Armes Réglementées
                </h3>
                <span class="text-sm text-gray-500">{{ count($weapons) }} références disponibles</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4 mb-12">

                @foreach($weapons as $weapon)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full overflow-hidden hover:-translate-y-1">

                        <div class="relative h-40 w-full bg-white p-4 flex items-center justify-center border-b border-gray-50">

                            <div class="absolute top-3 right-3 z-10">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border
                                    {{ $weapon->category === 'B' ? 'bg-red-50 text-red-700 border-red-100' : 'bg-yellow-50 text-yellow-700 border-yellow-100' }}">
                                    Cat. {{ $weapon->category }}
                                </span>
                            </div>

                            @if($weapon->image)
                                <img src="{{ Storage::url($weapon->image) }}"
                                     alt="{{ $weapon->model }}"
                                     class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="text-gray-300 flex flex-col items-center justify-center h-full w-full bg-gray-50 rounded-lg">
                                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] uppercase font-medium tracking-wider">Sans visuel</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5 flex-grow flex flex-col">
                            <div class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">
                                {{ $weapon->brand }}
                            </div>

                            <h4 class="text-base font-bold text-gray-900 leading-snug mb-4 line-clamp-2">
                                {{ $weapon->model }}
                            </h4>

                            <div class="mt-auto space-y-2 border-t border-dashed border-gray-100 pt-3">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-400">Calibre</span>
                                    <span class="font-semibold text-gray-700 bg-gray-50 px-2 py-0.5 rounded">{{ $weapon->caliber }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-400">Type</span>
                                    <span class="font-medium text-gray-700">{{ $weapon->type->name ?? $weapon->weaponType->name }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-5 pb-5 pt-0">
                            @auth
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="block text-lg font-bold text-gray-900">{{ number_format($weapon->price, 0, ',', ' ') }} €</span>
                                        <span class="text-[10px] font-bold uppercase tracking-wide {{ $weapon->quantity > 0 ? 'text-green-600' : 'text-red-500' }}">
                                            {{ $weapon->quantity > 0 ? 'En stock' : 'Épuisé' }}
                                        </span>
                                    </div>
                                </div>

                                <form action="#" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit"
                                            class="w-full justify-center inline-flex items-center px-4 py-2.5 rounded-xl font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150
                                            {{ $weapon->quantity > 0
                                                ? 'bg-gray-900 text-white hover:bg-indigo-600 shadow-md hover:shadow-lg'
                                                : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                                        {{ $weapon->quantity == 0 ? 'disabled' : '' }}>
                                        {{ $weapon->quantity > 0 ? 'Ajouter au panier' : 'Indisponible' }}
                                    </button>
                                </form>
                            @else
                                <div class="bg-gray-50 rounded-xl p-3 text-center border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-2">Connectez-vous pour voir le prix</p>
                                    <a href="{{ route('login') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                                        Accéder à mon compte
                                    </a>
                                </div>
                            @endauth
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
