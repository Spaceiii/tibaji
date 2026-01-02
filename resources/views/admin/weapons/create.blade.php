<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration / Ajouter une arme') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.weapons.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">

                    <div class="bg-gray-900 px-8 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-white">Nouvelle Référence</h3>
                        <span class="text-xs text-gray-400 uppercase tracking-widest">Tibaji Armory</span>
                    </div>

                    <div class="p-8 space-y-8">

                        <div>
                            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">
                                1. Visuel du produit
                            </h4>
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-indigo-400 transition duration-300 group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Cliquez pour upload</span> ou glissez le fichier ici</p>
                                        <p class="text-xs text-gray-500">PNG, JPG ou WEBP (Max. 2Mo)</p>
                                    </div>
                                    <input id="image" type="file" name="image" class="hidden" onchange="document.getElementById('file-name').innerText = this.files[0].name" />
                                </label>
                            </div>
                            <p id="file-name" class="mt-2 text-sm text-indigo-600 font-medium text-center h-5"></p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2 text-center" />
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">
                                2. Identification
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="brand" :value="__('Marque')" class="mb-1" />
                                    <x-text-input id="brand" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="brand" :value="old('brand')" required placeholder="Ex: Glock" />
                                    <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="model" :value="__('Modèle')" class="mb-1" />
                                    <x-text-input id="model" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="model" :value="old('model')" required placeholder="Ex: 17 Gen 5" />
                                    <x-input-error :messages="$errors->get('model')" class="mt-2" />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="weapon_type_id" :value="__('Type d\'arme')" class="mb-1" />
                                    <select name="weapon_type_id" id="weapon_type_id" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white">
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('weapon_type_id') == $type->id ? 'selected' : '' }}>
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
                                <div x-data="{ isManual: false }" class="relative">
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
                                            <option value="9mm">9mm</option>
                                            <option value="5.56mm">5.56mm</option>
                                            <option value="7.62mm">7.62mm</option>
                                            <option value="12 gauge">12 gauge</option>
                                            <option value=".45 ACP">.45 ACP</option>
                                            <option value=".22 LR">.22 LR</option>
                                            <option value=".308 Win">.308 Win</option>
                                            <option value=".338 Lapua">.338 Lapua</option>
                                            <option value="custom" class="font-bold text-indigo-600 bg-indigo-50">-- + Autre Calibre --</option>
                                        </select>

                                        <div x-show="isManual" style="display: none;"
                                             x-transition:enter="transition ease-out duration-200"
                                             class="flex gap-2 w-full">
                                            <x-text-input x-ref="manualInput"
                                                          type="text"
                                                          name="caliber_manual"
                                                          placeholder="Saisir manuellement..."
                                                          class="block w-full rounded-lg border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5"
                                                          x-bind:required="isManual" />

                                            <button type="button"
                                                    @click="isManual = false"
                                                    class="p-2.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-500 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('caliber')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category" :value="__('Catégorie Légale')" class="mb-1" />
                                    <select name="category" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white">
                                        <option value="B" {{ old('category') == 'B' ? 'selected' : '' }}>Catégorie B (Autorisation)</option>
                                        <option value="C" {{ old('category') == 'C' ? 'selected' : '' }}>Catégorie C (Déclaration)</option>
                                        <option value="D" {{ old('category') == 'D' ? 'selected' : '' }}>Catégorie D (Libre)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="serial_number" :value="__('Numéro de Série')" class="mb-1" />
                                    <x-text-input id="serial_number" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 font-mono" type="text" name="serial_number" :value="old('serial_number')" required placeholder="SN-XXXX" />
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
                                        <input type="number" name="price" id="price" step="0.01" class="block w-full rounded-lg border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 py-2.5" placeholder="0.00" value="{{ old('price') }}" required>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">EUR</span>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="quantity" :value="__('Stock Initial')" class="mb-1" />
                                    <x-text-input id="quantity" class="block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="number" name="quantity" :value="old('quantity')" required />
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div> <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.weapons.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 underline decoration-gray-300 underline-offset-4">
                            Annuler
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 focus:bg-indigo-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Enregistrer l'arme
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
