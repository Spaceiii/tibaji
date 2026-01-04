<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight uppercase tracking-wide">
            {{ __('Mise à jour du dossier') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">

                <div class="bg-indigo-900 px-6 py-4 border-b border-gray-800 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Licence de Tir & Permis
                    </h3>
                </div>

                <div class="p-8">

                    @if (session('status') === 'license-uploaded')
                        <div class="mb-8 bg-green-50 border-l-4 border-green-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700 font-bold">Document transmis avec succès !</p>
                                    <p class="text-xs text-green-600">Nos armuriers ont été notifiés.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($license && $license->status === 'approved')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
                            <div class="inline-block p-4 bg-green-100 rounded-full mb-4">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-green-900">Dossier Validé & Actif</h4>
                            <p class="text-green-800 text-sm mb-6">Vous êtes autorisé à commander sur la boutique.</p>

                            <dl class="grid grid-cols-2 gap-4 text-left max-w-md mx-auto bg-white p-6 rounded-xl border border-green-100 shadow-sm">
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider font-bold">Type</dt>
                                    <dd class="font-bold text-gray-900 text-lg">Catégorie {{ $license->level }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider font-bold">Numéro SIA</dt>
                                    <dd class="font-mono font-bold text-gray-900 text-lg">{{ $license->license_number }}</dd>
                                </div>
                                <div class="col-span-2 border-t border-gray-100 pt-3 mt-1">
                                    <dt class="text-xs text-gray-400 uppercase tracking-wider font-bold">Date d'expiration</dt>
                                    <dd class="font-bold {{ $license->isExpired() ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $license->expiration_date->format('d/m/Y') }}
                                        @if($license->isExpired()) (Expiré) @endif
                                    </dd>
                                </div>
                            </dl>

                            <div class="mt-8">
                                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-green-700 hover:text-green-900 underline">Retour au tableau de bord</a>
                            </div>
                        </div>

                    @elseif($license && $license->status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-10 text-center">
                            <div class="inline-block p-4 bg-yellow-100 rounded-full mb-6 animate-pulse">
                                <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-yellow-800">Vérification en cours</h4>
                            <p class="text-yellow-700 text-base mt-3 max-w-lg mx-auto leading-relaxed">
                                Votre document a été reçu le <strong>{{ $license->submitted_at->format('d/m/Y') }}</strong>.<br>
                                Nos équipes effectuent actuellement les vérifications légales obligatoires (FINIADA).
                            </p>
                            <p class="text-xs text-yellow-600 mt-6">Merci de votre patience. Vous recevrez une notification une fois validé.</p>

                            <div class="mt-8">
                                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-yellow-700 hover:text-yellow-900 underline">Retour au tableau de bord</a>
                            </div>
                        </div>

                    @else

                        @if($license && $license->status === 'rejected')
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wide">Dossier Refusé</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p class="font-bold">Motif du refus :</p>
                                            <p class="mt-1 italic">"{{ $license->admin_comment }}"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-6 text-sm text-gray-600 font-medium">Veuillez corriger les erreurs et soumettre un nouveau document ci-dessous :</p>
                        @else
                            <div class="mb-8 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            Pour acquérir des armes réglementées, la loi française impose la vérification de votre identité et de votre licence.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('license.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-1 md:col-span-2">
                                    <x-input-label for="level" value="Type de Document" class="mb-1" />
                                    <select name="level" id="level" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 bg-white">
                                        <option value="C">Licence de Tir FFTir / Ball-Trap (Cat. C)</option>
                                        <option value="C">Permis de Chasse Validé (Cat. C)</option>
                                        <option value="B">Autorisation Préfectorale (Cat. B)</option>
                                    </select>
                                </div>

                                <div>
                                    <x-input-label for="license_number" value="Numéro du titre / SIA" class="mb-1" />
                                    <x-text-input id="license_number" class="block w-full py-3" type="text" name="license_number" required placeholder="Ex: 2024998877" />
                                    <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="expiration_date" value="Date d'expiration" class="mb-1" />
                                    <x-text-input id="expiration_date" class="block w-full py-3" type="date" name="expiration_date" required />
                                    <x-input-error :messages="$errors->get('expiration_date')" class="mt-2" />
                                </div>
                            </div>

                            <div x-data="{ fileName: '' }" class="relative w-full">
                                <x-input-label value="Scan du document (PDF/JPG)" class="mb-2" />

                                <div class="relative border-2 border-dashed rounded-lg p-8 text-center transition group overflow-hidden"
                                     :class="fileName ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:bg-gray-50 hover:border-indigo-300'">

                                    <input type="file"
                                           name="license_file"
                                           id="license_file"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                           required
                                           x-ref="fileInput"
                                           @change="fileName = $refs.fileInput.files.length > 0 ? $refs.fileInput.files[0].name : ''" />

                                    <div x-show="!fileName" class="pointer-events-none">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600 font-medium">Cliquez pour ajouter votre scan</p>
                                        <p class="text-xs text-gray-400 mt-1">Fichier de moins de 4 Mo</p>
                                    </div>

                                    <div x-show="fileName" style="display: none;" class="pointer-events-none relative z-10">
                                        <div class="mx-auto h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mb-2 animate-bounce">
                                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-green-800">Fichier sélectionné !</p>
                                        <p class="text-xs text-gray-600 mt-1 font-mono truncate max-w-xs mx-auto" x-text="fileName"></p>
                                        <p class="text-[10px] text-indigo-600 mt-2 font-semibold uppercase tracking-wide">Cliquez pour changer</p>
                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('license_file')" class="mt-2" />

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-6">
                                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 font-medium">Annuler</a>
                                <button type="submit" class="bg-gray-900 text-white font-bold py-3 px-8 rounded-lg uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Envoyer le dossier
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
