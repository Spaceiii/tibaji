<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion du Stock (Accessoires)') }}
            </h2>
            <a href="{{ route('admin.accessories.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouvel accessoire
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
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4 text-center">État du Stock</th>
                            <th class="px-6 py-4 text-right">Prix</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($accessories as $accessory)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="h-12 w-16 bg-gray-100 rounded-lg border border-gray-200 overflow-hidden flex items-center justify-center">
                                        @if($accessory->image)
                                            <img src="{{ Storage::url($accessory->image) }}" class="h-full w-full object-contain" alt="Img">
                                        @else
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $accessory->name }}</div>
                                    @if($accessory->description)
                                        <div class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $accessory->description }}</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        {{ $accessory->accessoryType->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($accessory->quantity == 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-700">Rupture</span>
                                    @elseif($accessory->quantity < 10)
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-bold text-orange-600">{{ $accessory->quantity }}</span>
                                            <span class="text-[10px] text-orange-500 font-medium">Faible</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center">
                                            <span class="text-sm font-bold text-green-600">{{ $accessory->quantity }}</span>
                                            <span class="text-[10px] text-green-500 font-medium">En stock</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($accessory->price, 2, ',', ' ') }} €</span>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.accessories.edit', $accessory) }}" class="p-2 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded-full transition" title="Éditer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>

                                        <form action="{{ route('admin.accessories.destroy', $accessory) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-400 hover:text-red-700 hover:bg-red-50 rounded-full transition"
                                                    onclick="return confirm('Attention : Cette action est irréversible.\n\nVoulez-vous vraiment supprimer l\'accessoire : {{ $accessory->name }} ?')"
                                                    title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($accessories->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    Aucun accessoire dans la base de données.
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
