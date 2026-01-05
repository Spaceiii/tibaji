<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="transform hover:scale-105 transition duration-200">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-700" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')" class="font-medium hover:text-indigo-600 transition">
                        {{ __('Accueil') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ Auth::user()->role === 'admin' ? __('Tableau de bord') : __('Mon Espace') }}
                        </x-nav-link>
                    @endauth

                    <x-nav-link :href="route('catalog.index')" :active="request()->routeIs('catalog.index')">
                        {{ __('Catalogue') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.weapons.index')" :active="request()->routeIs('admin.weapons.*')">
                                {{ __('Gérer les Armes') }}
                            </x-nav-link>

                            <x-nav-link :href="route('admin.accessories.index')" :active="request()->routeIs('admin.accessories.*')">
                                {{ __('Gérer les Accessoires') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.licenses.index')" :active="request()->routeIs('admin.licenses.*')">
                                {{ __('Licences') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                {{ __('Gestion Commandes') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ __('Mon Panier') }}
                                @if(\App\Http\Controllers\CartController::getCartCount() > 0)
                                    <span class="bg-indigo-600 text-white py-0.5 px-2 rounded-full text-xs font-bold">{{ \App\Http\Controllers\CartController::getCartCount() }}</span>
                                @endif
                            </x-nav-link>

                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                                {{ __('Mes commandes') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border
                            {{ Auth::user()->role === 'admin'
                                ? 'bg-red-50 text-red-700 border-red-200'
                                : 'bg-green-50 text-green-700 border-green-200' }}">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 group">
                                    <div class="flex flex-col items-end">
                                        <span class="text-gray-800 font-semibold leading-tight">{{ Auth::user()->name }}</span>
                                        <span class="text-[10px] text-gray-400">{{ Auth::user()->email }}</span>
                                    </div>

                                    <div class="h-9 w-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md group-hover:bg-indigo-700 transition">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>

                                    <svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-gray-600 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                    <p class="text-xs text-gray-400 uppercase font-bold">Mon Compte</p>
                                </div>

                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Paramètres Profil') }}
                                </x-dropdown-link>

                                @if(Auth::user()->role !== 'admin')
                                    <x-dropdown-link :href="route('license.create')">
                                        {{ __('Ma Licence') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="text-red-600 hover:text-red-800 hover:bg-red-50"
                                                     onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Se déconnecter') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Se connecter</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold text-white bg-gray-900 rounded-lg hover:bg-indigo-600 transition shadow-md transform hover:-translate-y-0.5">
                                S'inscrire
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                {{ __('Accueil') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ Auth::user()->role === 'admin' ? __('Tableau de bord') : __('Mon Espace') }}
                </x-responsive-nav-link>
            @endauth

            <x-responsive-nav-link :href="route('catalog.index')" :active="request()->routeIs('catalog.index')">
                {{ __('Catalogue') }}
            </x-responsive-nav-link>

            @auth
                @if(Auth::user()->role === 'admin')
                    <div class="border-t border-gray-100 my-2 pt-2 px-4 text-xs font-bold text-indigo-500 uppercase tracking-widest">Admin</div>
                    <x-responsive-nav-link :href="route('admin.weapons.index')" :active="request()->routeIs('admin.weapons.*')">
                        {{ __('Gérer les Armes') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.accessories.index')" :active="request()->routeIs('admin.accessories.*')">
                        {{ __('Gérer les Accessoires') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.licenses.index')" :active="request()->routeIs('admin.licenses.*')">
                        {{ __('Vérification Permis') }}
                    </x-responsive-nav-link>
                @else
                    <div class="border-t border-gray-100 my-2 pt-2 px-4 text-xs font-bold text-indigo-500 uppercase tracking-widest">Client</div>
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')" class="flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ __('Mon Panier') }}
                        </span>
                        @if(\App\Http\Controllers\CartController::getCartCount() > 0)
                            <span class="bg-indigo-600 text-white py-1 px-2.5 rounded-full text-xs font-bold">{{ \App\Http\Controllers\CartController::getCartCount() }}</span>
                        @endif
                    </x-responsive-nav-link>

                @endif

            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
                <div class="px-4 flex items-center mb-2">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 px-2">
                    <x-responsive-nav-link :href="route('profile.edit')" class="rounded-md">
                        {{ __('Mon Profil') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" class="text-red-600 rounded-md hover:bg-red-50"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Se déconnecter') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-gray-200 px-4 bg-gray-50">
                <a href="{{ route('login') }}" class="block w-full text-center py-3 bg-white border border-gray-300 rounded-lg text-gray-700 font-bold mb-3 shadow-sm">Se connecter</a>
                <a href="{{ route('register') }}" class="block w-full text-center py-3 bg-gray-900 text-white rounded-lg font-bold shadow-md hover:bg-indigo-600 transition">S'inscrire</a>
            </div>
        @endauth
    </div>
</nav>
