<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
            {{ __('Mon Espace Tireur') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-600">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Bonjour, {{ Auth::user()->name }} !</h3>
                        <p class="text-gray-500 mt-1">Heureux de vous revoir sur l'armurerie Tibaji.</p>
                    </div>
                    <span class="px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest border
                        {{ Auth::user()->role === 'admin' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-green-50 text-green-700 border-green-200' }}">
                        Compte {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>

            @if(Auth::user()->role !== 'admin')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-6">

                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                            <div class="bg-gray-900 px-6 py-4 border-b border-gray-800 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    Mon Dossier Administratif
                                </h3>
                            </div>

                            <div class="p-6">
                                @if(Auth::user()->license && Auth::user()->license->status === 'approved')
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-2">
                                        <div class="flex items-start gap-4">
                                            <div class="bg-green-100 p-3 rounded-full">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-green-800">Dossier Validé & Actif</h4>
                                                <p class="text-green-700 text-sm mt-1">Autorisé à l'achat : Catégorie <strong>{{ Auth::user()->license->level }}</strong>.</p>
                                                <div class="text-xs text-gray-500 mt-2">
                                                    Valide jusqu'au {{ Auth::user()->license->expiration_date->format('d/m/Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @elseif(Auth::user()->license && Auth::user()->license->status === 'pending')
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                                        <div class="inline-block p-4 bg-yellow-100 rounded-full mb-4 animate-pulse">
                                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-yellow-800">Vérification en cours</h4>
                                        <p class="text-yellow-700 text-sm max-w-md mx-auto mt-2">
                                            Votre document est entre les mains de nos armuriers.
                                        </p>
                                    </div>

                                @else
                                    @if(Auth::user()->license && Auth::user()->license->status === 'rejected')
                                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 flex items-start gap-3">
                                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            <div>
                                                <h4 class="font-bold text-red-800">Dossier Refusé</h4>
                                                <p class="text-sm text-red-700 mt-1">{{ Auth::user()->license->admin_comment }}</p>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <a href="{{ route('license.create') }}" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                                                Soumettre un nouveau document
                                            </a>
                                        </div>
                                    @else
                                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6 text-center">
                                            <h4 class="font-bold text-blue-900 text-sm uppercase mb-1">Dossier Incomplet</h4>
                                            <p class="text-sm text-blue-800">
                                                Aucune licence active. Vous ne pouvez pas commander d'armes réglementées.
                                            </p>
                                        </div>

                                        <div class="text-center">
                                            <a href="{{ route('license.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-900 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-800 transition shadow-md">
                                                Soumettre ma licence / Permis
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-4 uppercase text-sm tracking-wide">Mon Profil</h4>
                            <div class="flex items-center gap-4 mb-4">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-xl font-bold text-gray-600">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block w-full text-center py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                Modifier mes informations
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-4 uppercase text-sm tracking-wide">Mes Réservations</h4>
                            <div class="text-center py-8 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <p class="text-sm">Aucune commande en cours.</p>
                                <a href="{{ route('catalog.index') }}" class="text-indigo-600 text-sm font-bold hover:underline mt-2 inline-block">Aller à la boutique</a>
                            </div>
                        </div>
                    </div>

                </div>

            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('admin.weapons.index') }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-indigo-500 transition group">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">Stock Armes</h5>
                            <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-indigo-100 text-gray-600 group-hover:text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm">Gérer l'inventaire, les prix et les ajouts.</p>
                    </a>

                    <a href="{{ route('admin.licenses.index') }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-indigo-500 transition group">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">Vérifications</h5>
                            <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-indigo-100 text-gray-600 group-hover:text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm">Valider les documents et permis des clients.</p>
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
