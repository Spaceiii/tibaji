<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes commandes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($orders->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune commande</h3>
                            <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore passé de commande.</p>
                            <div class="mt-6">
                                <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Parcourir le catalogue
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3 class="font-bold text-lg">Commande {{ $order->order_number }}</h3>
                                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->getStatusBadgeClass() }}">
                                            {{ $order->getStatusLabel() }}
                                        </span>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">{{ $order->items->count() }} article(s)</p>
                                        <p class="text-lg font-bold">{{ number_format($order->total_amount, 2) }} €</p>
                                    </div>

                                    @if($order->status === 'rejected' && $order->admin_comment)
                                        <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-400 text-red-700">
                                            <p class="text-sm font-medium">Raison du refus :</p>
                                            <p class="text-sm">{{ $order->admin_comment }}</p>
                                        </div>
                                    @endif

                                    <div class="flex gap-2">
                                        <a href="{{ route('orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                            Voir les détails →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
