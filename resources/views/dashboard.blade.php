<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Espace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-600">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold">Bonjour, {{ Auth::user()->name }} 👋</h3>
                        <p class="text-gray-500">Ravi de vous revoir sur l'armurerie Tibaji.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                        {{ Auth::user()->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        Compte {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <a href="{{ route('admin.weapons.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition">Stock Armes</h5>
                            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">Gérer l'inventaire des armes réglementées (Catégories B, C, D).</p>
                        <div class="mt-4 text-sm font-semibold text-indigo-600">Accéder au stock &rarr;</div>
                    </a>

                    <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm opacity-60">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold text-gray-500">Accessoires</h5>
                            <div class="p-3 bg-gray-100 rounded-full text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm">Gérer les optiques, munitions et équipements tactiques.</p>
                        <div class="mt-4 text-xs font-bold text-gray-400 uppercase tracking-wide">Bientôt disponible</div>
                    </div>

                    <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold text-gray-900">Vérifications</h5>
                            <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">Valider les permis de chasse et licences de tir des clients.</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-400">0 en attente</span>
                        </div>
                    </div>

                </div>

            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a1 1 0 01-1 1h-3a3 3 0 01-6 0H4a1 1 0 01-1-1V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM19 4a1 1 0 00-1 1v12a1 1 0 002 0V5a1 1 0 00-1-1zM4.25 18A3.75 3.75 0 00.5 21.75c0 .41.34.75.75.75H8.5c.41 0 .75-.34.75-.75A3.75 3.75 0 005.5 18h-1.25z"></path></svg>
                        </div>

                        <h5 class="text-lg font-bold text-gray-900 mb-2">Mon Permis</h5>

                        @if(Auth::user()->license)
                            <div class="flex items-center gap-2 text-green-600 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-semibold">Validé (Cat. {{ Auth::user()->license->level ?? '?' }})</span>
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-red-500 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span class="font-semibold">Non renseigné</span>
                            </div>
                            <p class="text-xs text-gray-500 mb-4">Requis pour acheter des armes de catégorie B, C. <br> (Licence FFT ou Permis de chasse)</p>
                            <button class="text-sm bg-gray-900 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                                Uploader mes documents
                            </button>
                        @endif
                    </div>

                    <a href="{{ route('catalog.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold text-gray-900">Boutique</h5>
                            <div class="p-3 bg-indigo-100 rounded-full text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">Parcourir notre catalogue d'armes et d'accessoires.</p>
                        <div class="mt-4 text-sm font-semibold text-indigo-600">Voir le catalogue &rarr;</div>
                    </a>

                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold text-gray-900">Mes Réservations</h5>
                            <div class="p-3 bg-green-100 rounded-full text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">Suivez l'état de vos réservations en cours.</p>
                        <div class="mt-4 border-t border-gray-100 pt-2">
                            <span class="text-xs text-gray-400 italic">Aucune réservation active.</span>
                        </div>
                    </div>

                </div>
            @endif

            <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4 flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-indigo-900">Information importante</h3>
                    <p class="mt-1 text-sm text-indigo-700">
                        Pour tout achat d'arme de catégorie B, la présentation originale de l'autorisation préfectorale sera exigée lors du retrait en magasin.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
