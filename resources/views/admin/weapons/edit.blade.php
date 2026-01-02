<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration / Modifier une arme') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.weapons.update', $weapon) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">

                    <div class="bg-indigo-900 px-8 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-white">Modification : {{ $weapon->model }}</h3>
                        <span class="text-xs text-indigo-200 uppercase tracking-widest">Réf: {{ $weapon->serial_number }}</span>
                    </div>

                    <div class="p-8 space-y-8">

                        <div>
                            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">
                                1. Visuel du produit
                            </h4>
                            <div class="flex gap-6 items-start">
                                @if($weapon->image)
                                    <div class="w-32 h-32 flex-shrink-0 border border-gray-200 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ Storage::url($weapon->image) }}" alt="Actuelle" class="w-full h-full object-contain">
                                    </div>
                                @endif

                                <div class="flex-grow">
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-400 transition duration-300 group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Cliquez pour modifier</span> l'image</p>
                                            <p class="text-xs text-gray-500">Laisser vide pour conserver l'actuelle</p>
                                        </div>
                                        <input id="image" type="file" name="image" class="hidden" onchange="document.getElementById('file-name').innerText = 'Nouvelle image : ' + this.files[0].name" />
                                    </label>
                                    <p id="file-name" class="mt-2 text-sm text-indigo-600 font-medium h-5"></p>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">
                                2. Identification
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="brand" :value="__('Marque')" class="mb-1" />
                                    <x-text-input id="brand" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="brand" :value="old('brand', $weapon->brand)" required />
                                    <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="model" :value="__('Modèle')" class="mb-1" />
                                    <x-text-input id="model" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="model" :value="old('model', $weapon->model)" required />
                                    <x-input-error :messages="$errors->get('model')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="weapon_type_id" :value="__('Type d\'arme')" class="mb-1" />
                                    <select name="weapon_type_id" id="weapon_type_id" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white">
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('weapon_type_id', $weapon->weapon_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('weapon_type_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">
                                3. Spécifications & Vente
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                                @php
                                    $standardCalibers = ['9mm', '5.56mm', '7.62mm', '12 gauge', '.45 ACP', '.22 LR', '.308 Win', '.338 Lapua'];
                                    $currentCaliber = old('caliber', $weapon->caliber);
                                    $isManualInit = !in_array($currentCaliber, $standardCalibers);
                                @endphp

                                <div x-data="{
    isManual: {{ $isManualInit ? 'true' : 'false' }},
    manualValue: '{{ $isManualInit ? $currentCaliber : '' }}'
}" class="relative">

                                    <x-input-label for="caliber" :value="__('Calibre')" class="mb-1" />

                                    <div class="relative">
                                        <select x-show="!isManual"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                name="caliber_select"
                                                class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white"
                                                @change="if($event.target.value === 'custom') { isManual = true; $nextTick(() => $refs.manualInput.focus()); }">
                                            <option value="">Sélectionner...</option>
                                            @foreach($standardCalibers as $cal)
                                                <option value="{{ $cal }}" {{ $currentCaliber == $cal ? 'selected' : '' }}>{{ $cal }}</option>
                                            @endforeach
                                            <option value="custom" class="font-bold text-indigo-600 bg-indigo-50">-- + Autre Calibre --</option>
                                        </select>

                                        <div x-show="isManual"
                                             x-cloak
                                             x-transition:enter="transition ease-out duration-200"
                                             class="flex gap-2 w-full">

                                            <x-text-input x-ref="manualInput"
                                                          type="text"
                                                          name="caliber_manual"
                                                          x-model="manualValue"
                                                          placeholder="Saisir manuellement..."
                                                          class="block w-full rounded-lg border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5"
                                                          x-bind:required="isManual" />

                                            <button type="button"
                                                    @click="isManual = false; manualValue = ''"
                                                    class="p-2.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-500 transition"
                                                    title="Revenir à la liste">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('caliber')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category" :value="__('Catégorie Légale')" class="mb-1" />
                                    <select name="category" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white">
                                        <option value="B" {{ old('category', $weapon->category) == 'B' ? 'selected' : '' }}>Catégorie B (Autorisation)</option>
                                        <option value="C" {{ old('category', $weapon->category) == 'C' ? 'selected' : '' }}>Catégorie C (Déclaration)</option>
                                        <option value="D" {{ old('category', $weapon->category) == 'D' ? 'selected' : '' }}>Catégorie D (Libre)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="serial_number" :value="__('Numéro de Série')" class="mb-1" />
                                    <x-text-input id="serial_number" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 font-mono" type="text" name="serial_number" :value="old('serial_number', $weapon->serial_number)" required />
                                    <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="price" :value="__('Prix Unitaire')" class="mb-1" />
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">€</span>
                                        </div>
                                        <input type="number" name="price" id="price" step="0.01" class="block w-full rounded-lg border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 py-2.5" value="{{ old('price', $weapon->price) }}" required>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">EUR</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="quantity" :value="__('Stock Actuel')" class="mb-1" />
                                    <x-text-input id="quantity" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="number" name="quantity" :value="old('quantity', $weapon->quantity)" required />
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 flex items-center justify-between">
                        <button type="button" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette arme ?')) document.getElementById('delete-form').submit();" class="text-red-600 hover:text-red-900 text-sm font-semibold underline decoration-red-200 hover:decoration-red-600 underline-offset-4 transition">
                            Supprimer définitivement
                        </button>

                        <div class="flex gap-4 items-center">
                            <a href="{{ route('admin.weapons.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 underline decoration-gray-300 underline-offset-4">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                Mettre à jour
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <form id="delete-form" action="{{ route('admin.weapons.destroy', $weapon) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>
</x-app-layout>
