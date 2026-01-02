<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter une nouvelle arme</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.weapons.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="brand" :value="__('Marque')" />
                            <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" required />
                        </div>
                        <div>
                            <x-input-label for="model" :value="__('Modèle')" />
                            <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="weapon_type_id" :value="__('Type d\'arme')" />
                        <select name="weapon_type_id" id="weapon_type_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <x-input-label for="caliber" :value="__('Calibre')" />
                            <x-text-input id="caliber" class="block mt-1 w-full" type="text" name="caliber" required />
                        </div>
                        <div>
                            <x-input-label for="category" :value="__('Catégorie')" />
                            <select name="category" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                                <option value="B">B (Autorisation)</option>
                                <option value="C">C (Déclaration)</option>
                                <option value="D">D (Libre)</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="serial_number" :value="__('N° Série')" />
                            <x-text-input id="serial_number" class="block mt-1 w-full" type="text" name="serial_number" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="price" :value="__('Prix (€)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" required />
                        </div>
                        <div>
                            <x-input-label for="quantity" :value="__('Stock')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" required />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                            Enregistrer l'arme
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
