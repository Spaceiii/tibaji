<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
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

                            <x-nav-link href="#" class="opacity-50 cursor-not-allowed" title="Bientôt disponible">
                                {{ __('Accessoires') }}
                            </x-nav-link>
                        @else
                            <x-nav-link href="#" :active="false">
                                {{ __('Mon Panier') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <span class="mr-4 px-2 py-1 text-xs font-bold rounded
                        {{ Auth::user()->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Mon Profil') }}
                            </x-dropdown-link>

                            @if(Auth::user()->role !== 'admin')
                                <x-dropdown-link href="#">
                                    {{ __('Ma Licence') }}
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Se déconnecter') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline hover:text-indigo-600 font-medium">Se connecter</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md transition">S'inscrire</a>
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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-50 border-t border-gray-200">
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
                    <div class="border-t border-gray-200 my-2 pt-2 px-4 text-xs font-bold text-gray-400 uppercase">Administration</div>
                    <x-responsive-nav-link :href="route('admin.weapons.index')" :active="request()->routeIs('admin.weapons.*')">
                        {{ __('Gérer les Armes') }}
                    </x-responsive-nav-link>
                @else
                    <div class="border-t border-gray-200 my-2 pt-2 px-4 text-xs font-bold text-gray-400 uppercase">Client</div>
                    <x-responsive-nav-link href="#">
                        {{ __('Mon Panier') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 bg-white">
                <div class="px-4 flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Mon Profil') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Se déconnecter') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="pt-2 pb-3 space-y-1 px-4">
                    <a href="{{ route('login') }}" class="block w-full text-center py-2 bg-white border border-gray-300 rounded-md text-gray-700 mb-2">Se connecter</a>
                    <a href="{{ route('register') }}" class="block w-full text-center py-2 bg-indigo-600 text-white rounded-md">Créer un compte</a>
                </div>
            </div>
        @endauth
    </div>
</nav>
