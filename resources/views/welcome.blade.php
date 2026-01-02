<x-app-layout>
    <div x-data="{
            activeSlide: 0,
            slides: [
                {
                    title: 'Nouvelle Collection Glock',
                    text: 'Fiabilité légendaire. Performance moderne. Disponibles dès maintenant.',
                    cta: 'Découvrir',
                    link: '{{ route('catalog.index') }}',
                    image: '{{ asset('welcome/glockeus.jpg') }}',
                    bg: 'bg-indigo-900'
                },
                {
                    title: 'L\'Excellence du Tir Sportif',
                    text: 'Découvrez notre sélection d\'armes de poing et d\'épaule pour la compétition.',
                    cta: 'Voir le catalogue',
                    link: '{{ route('catalog.index') }}',
                    image: '{{ asset('welcome/sport.jpg') }}',
                    bg: 'bg-gray-900'
                },
                {
                    title: 'Expertise & Conseil',
                    text: 'Une équipe de passionnés pour vous guider dans vos choix et démarches.',
                    cta: 'En savoir plus',
                    link: '#',
                    image: '{{ asset('welcome/springfMod2020.jpg') }}',
                    bg: 'bg-gray-800'
                }
            ],
            timer: null
         }"
         x-init="timer = setInterval(() => { activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1 }, 6000)"
         class="relative bg-gray-900 h-[600px] overflow-hidden group">

        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform scale-110"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="absolute inset-0 flex items-center justify-center text-center bg-cover bg-center bg-no-repeat"
                 :style="slide.image ? `background-image: url('${slide.image}')` : ''"
                 :class="!slide.image ? slide.bg : ''">

                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/80"></div>

                <div class="relative z-10 max-w-4xl px-6">
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight drop-shadow-xl" x-text="slide.title"></h1>
                    <p class="text-lg md:text-2xl text-gray-100 mb-10 font-medium max-w-2xl mx-auto leading-relaxed" x-text="slide.text"></p>

                    <a :href="slide.link" class="inline-block bg-white text-indigo-900 hover:bg-indigo-600 hover:text-white font-bold py-4 px-10 rounded-full transition-all duration-300 shadow-lg hover:shadow-indigo-500/50 transform hover:-translate-y-1">
                        <span x-text="slide.cta"></span>
                    </a>
                </div>
            </div>
        </template>

        <div class="absolute bottom-10 left-0 right-0 flex justify-center space-x-3 z-20">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index; clearInterval(timer); timer = setInterval(() => { activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1 }, 6000)"
                        class="h-3 w-3 rounded-full transition-all duration-300 shadow-sm"
                        :class="activeSlide === index ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/80'"></button>
            </template>
        </div>

        <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 p-4 text-white/50 hover:text-white hover:bg-white/10 rounded-full transition z-20 hidden md:block backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 p-4 text-white/50 hover:text-white hover:bg-white/10 rounded-full transition z-20 hidden md:block backdrop-blur-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <div class="bg-gray-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition duration-300 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 transform hover:rotate-6 transition duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Armurerie Agréée</h3>
                    <p class="text-gray-500 leading-relaxed">Certification officielle et respect strict de la législation française pour votre sécurité.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition duration-300 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 transform hover:rotate-6 transition duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Expertise Technique</h3>
                    <p class="text-gray-500 leading-relaxed">Chaque arme est minutieusement inspectée par nos armuriers diplômés.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm hover:shadow-md transition duration-300 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 transform hover:rotate-6 transition duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Stock Réel</h3>
                    <p class="text-gray-500 leading-relaxed">Pas de mauvaise surprise : tout ce qui est affiché est disponible immédiatement.</p>
                </div>

            </div>
        </div>
    </div>

    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 tracking-tight">Derniers Arrivages</h2>
                    <p class="mt-2 text-lg text-gray-500">Les nouvelles références fraîchement ajoutées.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center font-bold text-indigo-600 hover:text-indigo-800 transition mt-4 sm:mt-0 bg-indigo-50 px-5 py-2 rounded-full">
                    Tout le stock <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredWeapons as $weapon)
                    <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full overflow-hidden group hover:-translate-y-2">

                        <a href="{{ route('catalog.show', $weapon) }}" class="relative h-60 bg-gray-50 p-6 flex items-center justify-center overflow-hidden">
                            @if($weapon->quantity == 0)
                                <div class="absolute top-4 right-4 bg-red-100 text-red-600 text-xs font-bold px-3 py-1 rounded-full z-10">
                                    Rupture
                                </div>
                            @endif

                            @if($weapon->image)
                                <img src="{{ Storage::url($weapon->image) }}" alt="{{ $weapon->model }}" class="max-h-full max-w-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="text-gray-300 flex flex-col items-center"><span class="text-xs font-bold uppercase">Image N/A</span></div>
                            @endif
                        </a>

                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-indigo-500 uppercase tracking-wide">{{ $weapon->brand }}</span>
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">{{ $weapon->caliber }}</span>
                            </div>

                            <a href="{{ route('catalog.show', $weapon) }}">
                                <h4 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition line-clamp-2 leading-snug">{{ $weapon->model }}</h4>
                            </a>

                            <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-50">
                                @auth
                                    <span class="text-xl font-extrabold text-gray-900">{{ number_format($weapon->price, 2, ',', ' ') }} €</span>
                                @else
                                    <span class="text-xs text-gray-500 italic">Prix membre</span>
                                @endauth

                                <a href="{{ route('catalog.show', $weapon) }}" class="bg-gray-100 text-gray-600 p-2.5 rounded-full hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($featuredWeapons->isEmpty())
                    <div class="col-span-4 text-center py-16 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-500 font-medium">Le stock est en cours de mise à jour...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-12 text-center tracking-tight">Nos Univers</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <a href="{{ route('catalog.index') }}" class="group relative overflow-hidden h-96 rounded-[2.5rem] shadow-xl hover:shadow-2xl transition-all duration-500">
                    <div class="absolute inset-0 group-hover:scale-105 transition duration-1000 ease-in-out">
                        <img src="{{ asset('welcome/weapons.jpg') }}" alt="Armes à feu" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 translate-y-4 group-hover:translate-y-0 transition duration-500">
                        <div class="bg-white/20 p-4 rounded-full mb-4 backdrop-blur-md">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-4xl font-bold text-white mb-2 drop-shadow-md">Armes Réglementées</h3>
                        <p class="text-gray-200 mb-8 font-medium max-w-sm opacity-90">Pistolets, Carabines, Fusils pour le tir sportif.</p>

                        <span class="inline-flex items-center px-8 py-3 bg-white text-gray-900 font-bold rounded-full hover:bg-indigo-600 hover:text-white transition duration-300 shadow-lg">
                            Accéder au stock
                        </span>
                    </div>
                </a>

                <div class="group relative overflow-hidden h-96 rounded-[2.5rem] shadow-lg cursor-not-allowed">
                    <div class="absolute inset-0 grayscale">
                        <img src="{{ asset('welcome/munitions.jpg') }}" alt="Munitions" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-[2px]"></div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8">
                        <div class="bg-white/10 p-4 rounded-full mb-4">
                            <svg class="w-8 h-8 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-4xl font-bold text-white/50 mb-2">Accessoires</h3>
                        <p class="text-gray-400 mb-8 font-medium">Optiques • Chargeurs • Tactique</p>

                        <span class="inline-flex items-center px-6 py-2 bg-white/10 text-gray-300 font-bold rounded-full border border-white/20 backdrop-blur-md">
                            Bientôt disponible
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-white pt-20 pb-10 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">

                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <x-application-logo class="h-10 w-auto fill-current text-indigo-500" />
                        <span class="text-2xl font-bold tracking-tight">Tibaji</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        Votre armurerie de confiance pour le tir sportif et de loisir. Expertise, qualité et conformité réglementaire.
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 text-white">Navigation</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('welcome') }}" class="text-gray-400 hover:text-indigo-400 transition">Accueil</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="text-gray-400 hover:text-indigo-400 transition">Catalogue Armes</a></li>
                        <li><a href="#" class="text-gray-500 cursor-not-allowed">Accessoires (Bientôt)</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-indigo-400 transition">Mon Compte</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 text-white">Informations</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Mentions Légales</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Conditions Générales de Vente</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Politique de Confidentialité</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition">Réglementation Armes</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 text-white">Nous Contacter</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-indigo-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>123 Rue du Stand de Tir<br>75000 Paris, France</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>01 23 45 67 89</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>contact@tibaji-armory.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">© {{ date('Y') }} Tibaji Armory. Tous droits réservés.</p>
                <div class="flex gap-6">
                    <span class="text-gray-600 text-sm">Catégorie B</span>
                    <span class="text-gray-600 text-sm">Catégorie C</span>
                    <span class="text-gray-600 text-sm">Vente Réglementée</span>
                </div>
            </div>
        </div>
    </footer>
</x-app-layout>
