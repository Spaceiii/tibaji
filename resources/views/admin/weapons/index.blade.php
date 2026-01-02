<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion du Stock (Armes)') }}
            </h2>
            <a href="{{ route('admin.weapons.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouvelle arme
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-6 py-4">Visuel</th>
                            <th class="px-6 py-4">Référence</th>
                            <th class="px-6 py-4">Caractéristiques</th>
                            <th class="px-6 py-4">Catégorie</th>
                            <th class="px-6 py-4 text-center">État du Stock</th>
                            <th class="px-6 py-4 text-right">Prix</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($weapons as $weapon)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="h-12 w-16 bg-gray-100 rounded-lg border border-gray-200 overflow-hidden flex items-center justify-center">
                                        @if($weapon->image)
                                            <img src="{{ Storage::url($weapon->image) }}" class="h-full w-full object-contain" alt="Img">
                                        @else
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $weapon->model }}</div>
                                    <div class="text-xs text-indigo-600 font-semibold uppercase tracking-wide">{{ $weapon->brand }}</div>
                                    <div class="text-xs text-gray-400 font-mono mt-1">{{ $weapon->serial_number }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">{{ $weapon->weaponType->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500 bg-gray-100 inline-block px-2 py-0.5 rounded mt-1">
                                        {{ $weapon->caliber }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                        {{ $weapon->category === 'B' ? 'bg-red-50 text-red-700 border-red-100' :
                                          ($weapon->category === 'C' ? 'bg-yellow-50 text-yellow-700 border-yellow-100' : 'bg-green-50 text-green-700 border-green-100') }}">
                                        Cat. {{ $weapon->category }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($weapon->quantity == 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-700">Rupture</span>
                                    @elseif($weapon->quantity < 5)
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-bold text-orange-600">{{ $weapon->quantity }}</span>
                                            <span class="text-[10px] text-orange-500 font-medium">Faible</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-bold text-green-600">{{ $weapon->quantity }}</span>
                                            <span class="text-[10px] text-green-500 font-medium">En stock</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($weapon->price, 2, ',', ' ') }} €</span>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.weapons.edit', $weapon) }}" class="p-2 text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded-full transition" title="Éditer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>

                                        <form action="{{ route('admin.weapons.destroy', $weapon) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-400 hover:text-red-700 hover:bg-red-50 rounded-full transition"
                                                    onclick="return confirm('Attention : Cette action est irréversible.\n\nVoulez-vous vraiment supprimer l\'arme : {{ $weapon->model }} ?')"
                                                    title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($weapons->isEmpty())
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Aucune arme dans la base de données.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
