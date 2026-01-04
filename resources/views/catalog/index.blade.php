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
                <span class="text-sm font-medium text-gray-500 bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100">
                    {{ count($weapons) }} références
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4 mb-12">

                @foreach($weapons as $weapon)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full overflow-hidden hover:-translate-y-1">

                        <a href="{{ route('catalog.show', $weapon) }}" class="relative h-48 w-full bg-white p-4 flex items-center justify-center border-b border-gray-50 overflow-hidden">

                            <div class="absolute top-3 right-3 z-10">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border uppercase tracking-wide shadow-sm
                                    {{ $weapon->category === 'B' ? 'bg-red-50 text-red-700 border-red-100' :
                                      ($weapon->category === 'C' ? 'bg-yellow-50 text-yellow-700 border-yellow-100' : 'bg-green-50 text-green-700 border-green-100') }}">
                                    Cat. {{ $weapon->category }}
                                </span>
                            </div>

                            @if($weapon->image)
                                <img src="{{ Storage::url($weapon->image) }}"
                                     alt="{{ $weapon->model }}"
                                     class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="text-gray-300 flex flex-col items-center justify-center h-full w-full bg-gray-50 rounded-lg">
                                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] uppercase font-bold tracking-wider opacity-50">Image indisponible</span>
                                </div>
                            @endif
                        </a>

                        <div class="p-5 flex-grow flex flex-col">
                            <div class="flex justify-between items-start">
                                <div class="text-[10px] font-extrabold text-indigo-500 uppercase tracking-widest mb-1">
                                    {{ $weapon->brand }}
                                </div>
                            </div>

                            <a href="{{ route('catalog.show', $weapon) }}">
                                <h4 class="text-base font-bold text-gray-900 leading-snug mb-4 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    {{ $weapon->model }}
                                </h4>
                            </a>

                            <div class="mt-auto space-y-2 border-t border-dashed border-gray-100 pt-3">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-400 font-medium">Calibre</span>
                                    <span class="font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">{{ $weapon->caliber }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-400 font-medium">Type</span>
                                    <span class="font-medium text-gray-700">{{ $weapon->weaponType->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-5 pb-5 pt-0">
                            @auth
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="block text-lg font-extrabold text-gray-900">{{ number_format($weapon->price, 2, ',', ' ') }} €</span>
                                        @if($weapon->quantity > 0)
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <span class="relative flex h-2 w-2">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                                </span>
                                                <span class="text-[10px] font-bold uppercase tracking-wide text-green-600">En stock</span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                                <span class="text-[10px] font-bold uppercase tracking-wide text-red-500">Rupture</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex gap-2">

                                    <a href="{{ route('catalog.show', $weapon) }}"
                                       class="flex-1 inline-flex justify-center items-center px-4 py-3 bg-white border border-gray-300 rounded-xl font-bold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 hover:border-gray-300 transition ease-in-out duration-200"
                                       title="Voir la fiche détaillée">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    @if(Auth::user()->role !== 'admin')
                                        <form action="{{ route('cart.add') }}" method="POST" class="flex-[3]">
                                            @csrf
                                            <input type="hidden" name="type" value="weapon">
                                            <input type="hidden" name="id" value="{{ $weapon->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                    class="w-full justify-center inline-flex items-center px-4 py-3 rounded-xl font-bold text-xs uppercase tracking-widest transition ease-in-out duration-200 gap-2
                                                    {{ $weapon->quantity > 0
                                                        ? 'bg-gray-900 text-white hover:bg-indigo-600 shadow-md hover:shadow-lg hover:-translate-y-0.5'
                                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                                                {{ $weapon->quantity == 0 ? 'disabled' : '' }}>

                                                @if($weapon->quantity > 0)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    <span class="hidden sm:inline">Ajouter</span> @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                @endif
                                            </button>
                                        </form>
                                    @endif
                                </div>

                            @else
                                <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-2 italic">Prix réservé aux membres</p>
                                    <a href="{{ route('login') }}" class="block w-full py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition">
                                        Se connecter
                                    </a>
                                </div>
                            @endauth
                        </div>

                    </div>
                @endforeach

            </div>

            @if($weapons->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="bg-white p-6 rounded-full shadow-sm mb-4">
                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Le catalogue d'armes est vide</h3>
                    <p class="mt-1 text-sm text-gray-500">Revenez plus tard pour découvrir nos nouveaux produits.</p>
                </div>
            @endif

            <div id="accessoires" class="flex items-center justify-between mb-8 px-4 mt-16 pt-8 border-t-2 border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 border-l-4 border-emerald-600 pl-4">
                    Accessoires & Équipements
                </h3>
                <span class="text-sm font-medium text-gray-500 bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100">
                    {{ count($accessories) }} références
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4">

                @foreach($accessories as $accessory)
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full overflow-hidden hover:-translate-y-1">

                        <div class="relative h-48 w-full bg-white p-4 flex items-center justify-center border-b border-gray-50 overflow-hidden">

                            <div class="absolute top-3 right-3 z-10">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border uppercase tracking-wide shadow-sm bg-emerald-50 text-emerald-700 border-emerald-100">
                                    {{ $accessory->accessoryType->name ?? 'Accessoire' }}
                                </span>
                            </div>

                            @if($accessory->image)
                                <img src="{{ Storage::url($accessory->image) }}"
                                     alt="{{ $accessory->name }}"
                                     class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="text-gray-300 flex flex-col items-center justify-center h-full w-full bg-gray-50 rounded-lg">
                                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] uppercase font-bold tracking-wider opacity-50">Image indisponible</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5 flex-grow flex flex-col">
                            <h4 class="text-base font-bold text-gray-900 leading-snug mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                {{ $accessory->name }}
                            </h4>

                            @if($accessory->description)
                                <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $accessory->description }}</p>
                            @endif
                        </div>

                        <div class="px-5 pb-5 pt-0">
                            @auth
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <span class="block text-lg font-extrabold text-gray-900">{{ number_format($accessory->price, 2, ',', ' ') }} €</span>
                                        @if($accessory->quantity > 0)
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <span class="relative flex h-2 w-2">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                                </span>
                                                <span class="text-[10px] font-bold uppercase tracking-wide text-green-600">En stock</span>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                                <span class="text-[10px] font-bold uppercase tracking-wide text-red-500">Rupture</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if(Auth::user()->role !== 'admin')
                                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                        @csrf
                                        <input type="hidden" name="type" value="accessory">
                                        <input type="hidden" name="id" value="{{ $accessory->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                                class="w-full justify-center inline-flex items-center px-4 py-3 rounded-xl font-bold text-xs uppercase tracking-widest transition ease-in-out duration-200 gap-2
                                                {{ $accessory->quantity > 0
                                                    ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-md hover:shadow-lg hover:-translate-y-0.5'
                                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
                                            {{ $accessory->quantity == 0 ? 'disabled' : '' }}>

                                            @if($accessory->quantity > 0)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                <span>Ajouter au panier</span>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            @endif
                                        </button>
                                    </form>
                                @endif

                            @else
                                <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-2 italic">Prix réservé aux membres</p>
                                    <a href="{{ route('login') }}" class="block w-full py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">
                                        Se connecter
                                    </a>
                                </div>
                            @endauth
                        </div>

                    </div>
                @endforeach

            </div>

            @if($accessories->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="bg-white p-6 rounded-full shadow-sm mb-4">
                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Aucun accessoire disponible</h3>
                    <p class="mt-1 text-sm text-gray-500">Revenez plus tard pour découvrir notre sélection d'accessoires.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
