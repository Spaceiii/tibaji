<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de la réservation #') }}{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                &larr; Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Articles réservé</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $item->item_name }}</p>
                                        <p class="text-sm text-gray-500">
                                            Type : {{ $item->item_type === 'weapon' ? 'Arme' : 'Accessoire' }}
                                            @if($item->category) | Catégorie : {{ $item->category }} @endif
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">{{ $item->quantity }} x {{ number_format($item->price, 2) }} €</p>
                                        <p class="text-indigo-600 font-bold">{{ number_format($item->quantity * $item->price, 2) }} €</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 border-t pt-4 text-right">
                            <p class="text-gray-600">Total de la réserve</p>
                            <p class="text-3xl font-extrabold text-indigo-700">{{ number_format($order->total_amount, 2) }} €</p>
                        </div>
                    </div>

                    @if($order->status === 'pending')
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-400">
                            <h3 class="text-lg font-bold mb-4 text-gray-800">Décision d'administration</h3>
                            <div class="flex gap-4">
                                <form action="{{ route('admin.orders.approve', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Approuver cette réservation ?')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                                        Approuver la réservation
                                    </button>
                                </form>

                                <button onclick="document.getElementById('reject-form-container').classList.toggle('hidden')" class="bg-red-100 hover:bg-red-200 text-red-700 font-bold py-2 px-6 rounded-lg transition">
                                    Refuser...
                                </button>
                            </div>

                            <div id="reject-form-container" class="mt-6 hidden">
                                <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Motif du refus (sera envoyé au client)</label>
                                        <textarea name="admin_comment" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="3" placeholder="Ex: Licence expirée ou illisible..."></textarea>
                                    </div>
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                                        Confirmer le refus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif($order->status === 'approved')
                        <form action="{{ route('admin.orders.complete', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-lg shadow-lg">
                                Marquer comme terminée
                            </button>
                        </form>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Informations Client</h3>
                        <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                        <p class="text-xs text-gray-400 mt-2 italic">Inscrit le : {{ $order->user->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Vérification Licence</h3>
                        @php $license = $order->user->license; @endphp {{-- Accès via relation singulière définie dans User.php --}}

                        @if($license)
                            <div class="space-y-2">
                                <p><span class="text-gray-500">Numéro :</span> <span class="font-mono">{{ $license->license_number }}</span></p>
                                <p><span class="text-gray-500">Catégorie :</span> <span class="font-bold text-indigo-600">{{ $license->level }}</span></p>
                                <p><span class="text-gray-500">Statut :</span>
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $license->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($license->status) }}
                                    </span>
                                </p>
                                <p><span class="text-gray-500">Expire le :</span> {{ \Carbon\Carbon::parse($license->expiration_date)->format('d/m/Y') }}</p>

                                <div class="mt-4 pt-4 border-t">
                                    <a href="{{ route('admin.licenses.download', $license) }}" class="inline-flex items-center text-sm font-bold text-indigo-600 hover:underline">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Télécharger la pièce jointe
                                    </a>
                                </div>
                            </div>
                        @else
                            <p class="text-red-500 font-bold italic">Aucune licence enregistrée pour ce client.</p>
                        @endif
                    </div>

                    <div class="bg-gray-100 rounded-lg p-4">
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Historique réservation</p>
                        <ul class="text-xs space-y-1">
                            <li>Créée le : {{ $order->created_at->format('d/m/Y H:i') }}</li>
                            @if($order->approved_at) <li class="text-green-600">Approuvée le : {{ \Carbon\Carbon::parse($order->approved_at)->format('d/m/Y H:i') }}</li> @endif
                            @if($order->rejected_at) <li class="text-red-600">Refusée le : {{ \Carbon\Carbon::parse($order->rejected_at)->format('d/m/Y H:i') }}</li> @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
