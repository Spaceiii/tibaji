<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
            {{ __('Vérification des Documents') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-6" role="alert">
                        <p class="font-bold">Succès</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
                        <p class="font-bold">Attention</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Détails Licence</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Document</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($licenses as $license)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold">
                                            {{ substr($license->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $license->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $license->user->email }}</div>
                                            <div class="text-xs text-gray-400 mt-1">Soumis le {{ $license->submitted_at ? $license->submitted_at->format('d/m/Y') : 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><span class="font-semibold text-gray-500 w-12 inline-block">N°:</span> {{ $license->license_number }}</div>
                                    <div class="text-sm text-gray-900"><span class="font-semibold text-gray-500 w-12 inline-block">Cat:</span> <span class="font-bold">{{ $license->level }}</span></div>
                                    <div class="text-sm {{ $license->isExpired() ? 'text-red-600 font-bold' : 'text-green-600' }}">
                                        <span class="font-semibold text-gray-500 w-12 inline-block">Exp:</span> {{ $license->expiration_date->format('d/m/Y') }}
                                        @if($license->isExpired()) (Expiré) @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.licenses.download', $license) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Voir le scan
                                    </a>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($license->status === 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            En attente
                                        </span>
                                    @elseif($license->status === 'approved')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                            Validé
                                        </span>
                                        <div class="text-[10px] text-gray-400 mt-1">Par Admin</div>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                            Refusé
                                        </span>
                                        <div class="text-[10px] text-red-400 mt-1 max-w-[150px] truncate" title="{{ $license->admin_comment }}">{{ $license->admin_comment }}</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($license->status === 'pending')
                                        <div class="flex flex-col gap-2 items-end">
                                            <form action="{{ route('admin.licenses.approve', $license) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Valider
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.licenses.reject', $license) }}" method="POST"
                                                  onsubmit="let reason = prompt('Veuillez indiquer le motif du refus (ex: Date expirée, Document illisible) :');
                                                            if(reason) {
                                                                let input = document.createElement('input');
                                                                input.type = 'hidden';
                                                                input.name = 'admin_comment';
                                                                input.value = reason;
                                                                this.appendChild(input);
                                                                return true;
                                                            }
                                                            return false;">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                    Refuser
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Aucune action</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if($licenses->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun document</h3>
                                    <p class="mt-1 text-sm text-gray-500">Aucune licence n'a été soumise pour le moment.</p>
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
