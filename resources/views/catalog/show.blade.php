<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $weapon->brand }} {{ $weapon->model }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center hover:text-indigo-600 transition">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Catalogue
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-700 font-medium md:ml-2">{{ $weapon->model }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">

                    <div class="bg-gray-100 p-10 flex items-center justify-center border-b md:border-b-0 md:border-r border-gray-100 relative">
                        <div class="absolute top-6 left-6">
                            <span class="px-4 py-2 rounded-lg text-sm font-bold shadow-sm
                                {{ $weapon->category === 'B' ? 'bg-red-600 text-white' : 'bg-yellow-500 text-white' }}">
                                Catégorie {{ $weapon->category }}
                            </span>
                        </div>

                        @if($weapon->image)
                            <img src="{{ Storage::url($weapon->image) }}"
                                 alt="{{ $weapon->model }}"
                                 class="max-w-full max-h-[500px] object-contain drop-shadow-2xl transform hover:scale-105 transition duration-500">
                        @else
                            <div class="text-gray-400 flex flex-col items-center">
                                <svg class="w-24 h-24 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="uppercase font-bold tracking-widest">Pas de visuel</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-8 md:p-12 flex flex-col">

                        <div class="mb-6">
                            <h3 class="text-indigo-600 font-bold uppercase tracking-widest text-sm mb-2">{{ $weapon->brand }}</h3>
                            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">{{ $weapon->model }}</h1>

                            @auth
                                <div class="flex items-center gap-4">
                                    <span class="text-3xl font-bold text-gray-900">{{ number_format($weapon->price, 2, ',', ' ') }} €</span>

                                    @if($weapon->quantity > 0)
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                            En Stock ({{ $weapon->quantity }})
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                            Rupture de stock
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 inline-block">
                                    <p class="text-sm text-gray-500 italic mb-1">Prix réservé aux membres</p>
                                    <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Se connecter</a>
                                </div>
                            @endauth
                        </div>

                        <div class="mb-8 bg-gray-50 rounded-xl p-6 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Fiche Technique</h4>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-4 text-sm">
                                <div>
                                    <dt class="text-gray-500">Calibre</dt>
                                    <dd class="font-semibold text-gray-900">{{ $weapon->caliber }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Type</dt>
                                    <dd class="font-semibold text-gray-900">{{ $weapon->weaponType->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Référence</dt>
                                    <dd class="font-mono text-gray-700">{{ $weapon->serial_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Législation</dt>
                                    <dd class="font-semibold text-gray-900">Soumis à autorisation (Cat. {{ $weapon->category }})</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="prose prose-indigo text-gray-600 mb-8 flex-grow">
                            <h4 class="font-bold text-gray-900 mb-2">Description</h4>
                            <p>
                                {{ $weapon->description ?? "Aucune description détaillée n'est disponible pour ce produit pour le moment. Veuillez contacter l'armurerie pour plus d'informations." }}
                            </p>
                        </div>

                        <div class="mt-auto pt-6 border-t border-gray-100">
                            @auth
                                @if($weapon->quantity > 0)
                                    <form action="#" method="POST"> @csrf
                                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center gap-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Ajouter au panier
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-4 px-8 rounded-xl cursor-not-allowed">
                                        Produit indisponible
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center bg-gray-900 hover:bg-gray-800 text-white font-bold py-4 px-8 rounded-xl transition">
                                    Connectez-vous pour commander
                                </a>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
