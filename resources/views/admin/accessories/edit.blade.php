<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration / Modifier un accessoire') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.accessories.update', $accessory) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">

                    <div class="bg-emerald-900 px-8 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-white">Modification : {{ $accessory->name }}</h3>
                        <span class="text-xs text-emerald-200 uppercase tracking-widest">{{ $accessory->accessoryType->name ?? 'N/A' }}</span>
                    </div>

                    <div class="p-8 space-y-8">

                        <div>
                            <h4 class="text-sm font-bold text-emerald-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">1. Visuel du produit</h4>
                            <div class="flex gap-6 items-start">
                                @if($accessory->image)
                                    <div class="w-32 h-32 flex-shrink-0 border border-gray-200 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="{{ Storage::url($accessory->image) }}" alt="Actuelle" class="w-full h-full object-contain">
                                    </div>
                                @endif

                                <div class="flex-grow">
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-emerald-400 transition duration-300 group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-3 text-gray-400 group-hover:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Cliquez pour modifier</span></p>
                                        </div>
                                        <input id="image" type="file" name="image" class="hidden" onchange="document.getElementById('file-name').innerText = 'Nouvelle image : ' + this.files[0].name" />
                                    </label>
                                    <p id="file-name" class="mt-2 text-sm text-emerald-600 font-medium h-5"></p>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-emerald-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">2. Identification</h4>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <x-input-label for="name" :value="__('Nom de l\'accessoire')" class="mb-1" />
                                    <x-text-input id="name" class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5" type="text" name="name" :value="old('name', $accessory->name)" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="accessory_type_id" :value="__('Type d\'accessoire')" class="mb-1" />
                                    <select name="accessory_type_id" id="accessory_type_id" class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5 bg-white">
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('accessory_type_id', $accessory->accessory_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('accessory_type_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Description (Optionnelle)')" class="mb-1" />
                                    <textarea id="description" name="description" rows="4" class="block w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" placeholder="Caractéristiques, compatibilité, matériaux...">{{ old('description', $accessory->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-emerald-600 uppercase tracking-wide mb-4 border-b border-gray-100 pb-2">3. Tarification & Stock</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="price" :value="__('Prix')" class="mb-1" />
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"><span class="text-gray-500 sm:text-sm">€</span></div>
                                        <input type="number" name="price" id="price" step="0.01" class="block w-full rounded-lg border-gray-300 pl-7 pr-12 shadow-sm py-2.5" value="{{ old('price', $accessory->price) }}" required>
                                    </div>
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="quantity" :value="__('Stock')" class="mb-1" />
                                    <x-text-input id="quantity" class="block w-full rounded-lg border-gray-300 shadow-sm py-2.5" type="number" name="quantity" :value="old('quantity', $accessory->quantity)" required />
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-50 px-8 py-5 border-t border-gray-200 flex items-center justify-between">
                        <button type="button" onclick="if(confirm('Supprimer cet accessoire définitivement ?')) document.getElementById('delete-form').submit();" class="text-red-600 hover:text-red-900 text-sm font-semibold underline decoration-red-200 hover:decoration-red-600 underline-offset-4 transition">
                            Supprimer
                        </button>

                        <div class="flex gap-4 items-center">
                            <a href="{{ route('admin.accessories.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 underline decoration-gray-300 underline-offset-4">Annuler</a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition shadow-md">Mettre à jour</button>
                        </div>
                    </div>

                </div>
            </form>

            <form id="delete-form" action="{{ route('admin.accessories.destroy', $accessory) }}" method="POST" style="display: none;">
                @csrf @method('DELETE')
            </form>

        </div>
    </div>
</x-app-layout>
