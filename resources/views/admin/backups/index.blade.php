@extends('layouts.admin')

@section('admin-content')
    @php
        use Illuminate\Support\Collection;

        $backupsFilesUploaded = collect($backupsFiles)->filter(function ($b) {
            return isset($b->metadata['is_uploaded']) && $b->metadata['is_uploaded'] === true;
        });

        $backupsFilesNoUploaded = collect($backupsFiles)->filter(function ($b) {
            return empty($b->metadata['is_uploaded']);
        });

        // Trouver la sauvegarde la plus récente
        $latestBackup = collect($backupsFilesNoUploaded)->sortByDesc('created_at')->first();
    @endphp


    <div class="min-h-screen w-full bg-gray-100 p-5">
        <div class="w-full p-5">
            <h1 class="text-3xl font-bold text-gray-800">{{ __('backup.parametres') }}</h1>
        </div>

        <div class="mt-5 w-full space-y-5 p-5">
            <!-- Sauvegardes Section -->
            <div class="rounded-lg bg-white p-5 shadow">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">{{ __('backup.backup') }}</h2>

                    <button onclick="openModal('backupModal')"
                        class="bg-supaGirlRose hover:bg-green-gs transform rounded-lg px-4 py-2 text-white shadow transition duration-300 ease-in-out hover:scale-105">
                        {{ __('backup.backup') }}
                    </button>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <!-- Tableau des sauvegardes -->
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.nom') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    <button onclick="sortTable(1)" class="flex items-center">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4h18M3 8h18M3 12h18m-9 4h9m-9 4h9m-9-8v8m0-8l4 4m-4-4l-4 4" />
                                        </svg>
                                        {{ __('backup.taille_db') }}
                                    </button>
                                </th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    <button onclick="sortTable(2)" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4h18M3 8h18M3 12h18m-9 4h9m-9 4h9m-9-8v8m0-8l4 4m-4-4l-4 4" />
                                        </svg>
                                        {{ __('backup.taille_storage') }}
                                    </button>
                                </th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.source') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    <button onclick="sortTable(4)" class="flex items-center">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4h18M3 8h18M3 12h18m-9 4h9m-9 4h9m-9-8v8m0-8l4 4m-4-4l-4 4" />
                                        </svg>
                                        {{ __('backup.date') }}
                                    </button>
                                </th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.statut') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.actions') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.restaurer') }}</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($backupsFilesNoUploaded as $backupFile)
                                <tr @if ($backupFile->id === $latestBackup->id) class="bg-fieldBg" @endif>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">{{ $backupFile->name }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        {{ $backupFile->getFormattedSizeAttribute($backupFile->size_db) }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        {{ $backupFile->getFormattedSizeAttribute($backupFile->size_storage) }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        {{ $backupFile->metadata['source'] }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">{{ $backupFile->created_at }}
                                    </td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        <span
                                            class="{{ $backupFile->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full px-2 py-1 text-xs">
                                            {{ $backupFile->status == 'completed' ? __('backup.statut_success') : __('backup.statut_failed') }}
                                        </span>
                                    </td>
                                    <td class="flex space-x-2 border-b border-gray-200 px-4 py-2">
                                        <!-- Bouton Supprimer -->
                                        <button
                                            onclick="openConfirmModal('delete', '{{ route('backups.destroy', $backupFile->id) }}')"
                                            class="py-2 text-red-500 hover:text-red-700 focus:outline-none"
                                            title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 transition-transform duration-200 hover:scale-110"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <!-- Bouton Télécharger -->
                                        <button
                                            onclick="openConfirmModal('download', '{{ route('backups.download', $backupFile->id) }}')"
                                            class="py-2 text-blue-500 hover:text-blue-700 focus:outline-none"
                                            title="Télécharger">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 transition-transform duration-200 hover:scale-110"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </button>

                                    </td>
                                    <td class="border-b border-gray-200 px-4 py-2">
                                        <button type="button"
                                            class="text-supaGirlRose hover:text-green-700 focus:outline-none"
                                            onclick="openModalRestauration('restoreModal', {{ $backupFile->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                            @if ($backupsFilesNoUploaded->isEmpty())
                                <tr>
                                    <td colspan="7" class="mt-5 px-4 py-2 text-center">
                                        {{ __('backup.no_backups_found') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Restauration Section -->
            <div class="rounded-lg bg-white p-5 shadow">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">{{ __('backup.import') }}</h2>
                    <x-modalUpload />
                </div>

                <div class="max-h-96 overflow-y-auto">
                    <!-- Tableau des sauvegardes -->
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.nom') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.taille_db') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.taille_storage') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.source') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.date') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.statut') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.actions') }}</th>
                                <th
                                    class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                    {{ __('backup.restaurer') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($backupsFilesUploaded as $backupFile)
                                <tr>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">{{ $backupFile->name }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        {{ $backupFile->getFormattedSizeAttribute($backupFile->size_db) }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        {{ $backupFile->getFormattedSizeAttribute($backupFile->size_storage) }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        {{ $backupFile->metadata['source'] }}</td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">{{ $backupFile->created_at }}
                                    </td>
                                    <td class="border-b border-gray-200 px-4 py-2 text-sm">
                                        <span
                                            class="{{ $backupFile->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full px-2 py-1 text-xs">
                                            {{ $backupFile->status == 'completed' ? __('backup.statut_success') : __('backup.statut_failed') }}
                                        </span>
                                    </td>
                                    <td class="flex space-x-2 border-b border-gray-200 px-4 py-2">
                                        <!-- Bouton Supprimer -->
                                        <button
                                            onclick="openConfirmModal('delete', '{{ route('backups.destroy', $backupFile->id) }}')"
                                            class="py-2 text-red-500 hover:text-red-700 focus:outline-none"
                                            title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 transition-transform duration-200 hover:scale-110"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        <!-- Bouton Télécharger -->
                                        <button
                                            onclick="openConfirmModal('download', '{{ route('backups.download', $backupFile->id) }}')"
                                            class="py-2 text-blue-500 hover:text-blue-700 focus:outline-none"
                                            title="Télécharger">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 transition-transform duration-200 hover:scale-110"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </button>

                                    </td>
                                    <td class="border-b border-gray-200 px-4 py-2">
                                        <button type="button"
                                            class="text-supaGirlRose hover:text-green-gs focus:outline-none"
                                            onclick="openModalRestauration('restoreModal', {{ $backupFile->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                            @if ($backupsFilesUploaded->isEmpty())
                                <tr>
                                    <td colspan="7" class="mt-5 px-4 py-2 text-center">
                                        {{ __('backup.no_backups_found') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal de confirmation de sauvegarde -->
        <div id="backupModal" class="fixed left-0 top-0 z-50 hidden h-full w-full bg-black/50">
            <div class="flex h-full w-full items-center justify-center">
                <div class="relative h-52 w-96 rounded-lg bg-white p-5 shadow-lg">

                    <!-- Loader animé -->
                    <div id="backupLoader"
                        class="absolute left-0 top-0 flex hidden h-full w-full flex-col items-center justify-center rounded-lg bg-white">
                        <div class="border-supaGirlRose h-16 w-16 animate-spin rounded-full border-t-4 border-opacity-75">
                        </div>
                        <p class="mt-5 flex items-center text-sm text-gray-500">
                            {{ __('backup.backup_loader') }}<span class="dot-animation ml-1"></span>
                        </p>
                    </div>

                    <!-- Contenu du modal -->
                    <div class="text-center" id="backupModalContent">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('backup.confirmation_backup') }}
                        </h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">{{ __('backup.confirmation_backup_message') }}</p>
                        </div>
                        <div class="mt-4 flex flex-row justify-center space-x-4">
                            <button id="cancelBackup" onclick="closeModal('backupModal')"
                                class="w-full rounded-md bg-gray-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                {{ __('backup.cancel') }}
                            </button>
                            <form action="{{ route('backups.create') }}" method="POST" class="w-full"
                                onsubmit="showBackupLoader(event)">
                                @csrf
                                @method('POST')
                                <button type="submit" id="confirmBackupBtn"
                                    class="bg-green-gs hover:bg-supaGirlRose focus:ring-green-gs w-full rounded-md px-4 py-2 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2">
                                    {{ __('backup.confirm') }}
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div id="actionConfirmModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/50">
            <div class="w-96 rounded-lg bg-white p-6 text-center shadow-lg">
                <h2 class="mb-2 text-lg font-semibold text-gray-800" id="confirmModalTitle">
                    {{ __('backup.confirm_action') }}</h2>
                <p class="mb-4 text-sm text-gray-600" id="confirmModalMessage">
                    {{ __('backup.confirmation_backup_message') }}</p>
                <form id="confirmModalForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="confirmModalMethod">
                    <div class="flex justify-center space-x-4">
                        <button type="button" onclick="closeConfirmModal()"
                            class="rounded bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400">{{ __('backup.cancel') }}</button>
                        <button type="submit"
                            class="bg-green-gs hover:bg-supaGirlRose rounded px-4 py-2 text-white">{{ __('backup.confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Modal de confirmation de restauration -->
        <div id="restoreModal" data-id="" class="fixed left-0 top-0 z-50 hidden h-full w-full bg-black/50">
            <div class="flex h-full w-full items-center justify-center">
                <div class="relative h-72 w-96 rounded-lg bg-white p-5 shadow-lg">

                    <!-- Loader animé -->
                    <div id="restoreLoader"
                        class="absolute left-0 top-0 flex hidden h-full w-full flex-col items-center justify-center rounded-lg bg-white">
                        <div class="border-supaGirlRose h-16 w-16 animate-spin rounded-full border-t-4 border-opacity-75">
                        </div>
                        <p class="mt-5 flex items-center text-sm text-gray-500">
                            {{ __('backup.restore_loader') }}<span class="dot-animation ml-1"></span>
                        </p>
                    </div>

                    <!-- Contenu du modal -->
                    <div class="mt-3 text-center" id="restoreModalContent">
                        <h3 class="text-green-gs text-lg font-medium leading-6">{{ __('backup.confirmation_restore') }}
                        </h3>
                        <div class="mt-2 py-2">
                            <p class="text-sm text-gray-500">{{ __('backup.confirmation_restore_message') }}</p>
                            <div class="mt-4 text-left">
                                <label for="restorePassword"
                                    class="block py-2 text-sm font-medium text-gray-700">{{ __('backup.restore_password') }}
                                    <span class="text-red-500">*</span></label>
                                <input type="password" id="restorePassword" placeholder="Mot de passe"
                                    class="border-green-gs focus:ring-green-gs focus:border-green-gs w-full rounded-md border px-3 py-2 shadow-sm focus:outline-none">
                            </div>
                        </div>
                        <div class="mt-4 flex flex-row justify-center space-x-4">
                            <button id="cancelRestore" onclick="closeModal('restoreModal')"
                                class="w-full rounded-md bg-gray-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                {{ __('backup.cancel') }}
                            </button>
                            <button type="submit" id="confirmRestoreBtn" onclick="confirmRestore()"
                                class="bg-green-gs hover:bg-supaGirlRose focus:ring-green-gs w-full cursor-not-allowed rounded-md px-4 py-2 text-base font-medium text-white opacity-50 shadow-sm focus:outline-none focus:ring-2"
                                disabled>
                                {{ __('backup.confirm') }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>




        <style>
            .dot-animation::after {
                content: '';
                display: inline-block;
                width: 1em;
                text-align: left;
                animation: dots 1.5s steps(4, end) infinite;
            }

            @keyframes dots {
                0% {
                    content: '';
                }

                25% {
                    content: '.';
                }

                50% {
                    content: '..';
                }

                75% {
                    content: '...';
                }

                100% {
                    content: '';
                }
            }
        </style>




        <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function openModalRestauration(modalId, id) {
                document.getElementById(modalId).classList.remove('hidden');
                document.getElementById('restoreModal').dataset.id = id;
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            function openModalUpload() {
                document.getElementById('uploadModal').classList.remove('hidden');
            }

            // function confirmRestore() {
            //     const password = document.getElementById('restorePassword').value;
            //     const id = document.getElementById('restoreModal').dataset.id;
            //     console.log(id);
            //     console.log(password);
            //     fetch('/admin/backups/restore', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //         },
            //         body: JSON.stringify({
            //             id: id,
            //             password: password
            //         })
            //     })
            //     .then(response => {
            //         if (response.ok) {
            //             closeModal('restoreModal');
            //             setTimeout(() => window.location.reload(), 1500);
            //             showToast('success', 'Restauration terminée avec succès');
            //         } else {
            //             response.json().then(data => {
            //                 showToast('error', data.message);
            //             });
            //         }
            //     })
            //     .catch(error => {
            //         console.error('Erreur lors de la restauration:', error);
            //         showToast('error', 'Erreur lors de la restauration');
            //     });
            // }

            function confirmRestore() {
                const passwordInput = document.getElementById('restorePassword');
                const password = passwordInput.value;
                const modal = document.getElementById('restoreModal');
                const id = modal.dataset.id;

                // Reset styles
                passwordInput.classList.remove('border-red-500', 'focus:border-red-500');

                // Affiche le loader
                document.getElementById('restoreLoader').classList.remove('hidden');
                document.getElementById('restoreModalContent').classList.add('hidden');

                fetch('/admin/backups/restore', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            id,
                            password
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            closeModal('restoreModal');
                            setTimeout(() => window.location.reload(), 1500);
                            showToast('success', '{{ __('backup.restore_end_success') }}');
                        } else {
                            response.json().then(data => {
                                showToast('error', data.message);

                                // Réaffiche le formulaire et indique l'erreur
                                document.getElementById('restoreLoader').classList.add('hidden');
                                document.getElementById('restoreModalContent').classList.remove('hidden');
                                passwordInput.classList.add('border-red-500', 'focus:border-red-500');
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la restauration:', error);
                        showToast('error', 'Erreur lors de la restauration');

                        // Réaffiche le formulaire en cas d'erreur réseau
                        document.getElementById('restoreLoader').classList.add('hidden');
                        document.getElementById('restoreModalContent').classList.remove('hidden');
                        passwordInput.classList.add('border-red-500', 'focus:border-red-500');
                    });
            }

            function confirmBackup() {
                fetch('/admin/backups', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            closeModal('backupModal');
                        } else {
                            alert('{{ __('backup.error_sauvegarde') }}');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la sauvegarde:', error);
                        alert('{{ __('backup.error_sauvegarde') }}');
                    });
            }


            function showBackupLoader(event) {
                event.preventDefault();

                // Affiche le loader et masque le contenu
                document.getElementById('backupLoader').classList.remove('hidden');
                document.getElementById('backupModalContent').classList.add('hidden');

                // Désactive le bouton
                const btn = document.getElementById('confirmBackupBtn');
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');

                // Soumet le formulaire après un petit délai
                setTimeout(() => {
                    event.target.submit();
                }, 300);
            }


            const restorePasswordInput = document.getElementById('restorePassword');
            const confirmRestoreBtn = document.getElementById('confirmRestoreBtn');

            restorePasswordInput.addEventListener('input', function() {
                const hasValue = restorePasswordInput.value.trim().length > 0;

                confirmRestoreBtn.disabled = !hasValue;

                if (hasValue) {
                    confirmRestoreBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    confirmRestoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });


            function openConfirmModal(action, route) {
                const modal = document.getElementById('actionConfirmModal');
                const form = document.getElementById('confirmModalForm');
                const methodInput = document.getElementById('confirmModalMethod');
                const title = document.getElementById('confirmModalTitle');
                const message = document.getElementById('confirmModalMessage');

                form.action = route;

                // Supprime tout ancien écouteur
                form.onsubmit = null;

                if (action === 'delete') {
                    methodInput.value = 'DELETE';
                    title.textContent = '{{ __('backup.delete_confirmation') }}';
                    message.textContent = '{{ __('backup.delete_confirmation_message') }}';
                } else if (action === 'download') {
                    methodInput.value = 'GET';
                    title.textContent = '{{ __('backup.download_confirmation') }}';
                    message.textContent = '{{ __('backup.download_confirmation_message') }}';

                    // Fermer le modal dès que le téléchargement commence
                    form.onsubmit = function() {
                        closeConfirmModal();
                        return true; // permet au formulaire de continuer
                    };
                }

                modal.classList.remove('hidden');
            }

            function closeConfirmModal() {
                document.getElementById('actionConfirmModal').classList.add('hidden');
            }

            let sortDirection = {
                1: 'none',
                2: 'none',
                4: 'none'
            };

            function sortTable(columnIndex) {
                const table = document.querySelector('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                // Détermine la direction du tri
                if (sortDirection[columnIndex] === 'none' || sortDirection[columnIndex] === 'desc') {
                    sortDirection[columnIndex] = 'asc';
                } else {
                    sortDirection[columnIndex] = 'desc';
                }

                // Trie les lignes
                rows.sort((rowA, rowB) => {
                    const cellA = rowA.cells[columnIndex].textContent.trim();
                    const cellB = rowB.cells[columnIndex].textContent.trim();

                    // Convertit en nombre si c'est une colonne de taille
                    if (columnIndex === 1 || columnIndex === 2) {
                        const numA = parseFloat(cellA);
                        const numB = parseFloat(cellB);

                        if (sortDirection[columnIndex] === 'asc') {
                            return numA - numB;
                        } else {
                            return numB - numA;
                        }
                    }

                    // Compare les dates
                    if (columnIndex === 4) {
                        const dateA = new Date(cellA);
                        const dateB = new Date(cellB);

                        if (sortDirection[columnIndex] === 'asc') {
                            return dateA - dateB;
                        } else {
                            return dateB - dateA;
                        }
                    }

                    // Compare les chaînes de caractères
                    if (sortDirection[columnIndex] === 'asc') {
                        return cellA.localeCompare(cellB);
                    } else {
                        return cellB.localeCompare(cellA);
                    }
                });

                // Réinsère les lignes triées dans le tableau
                rows.forEach(row => tbody.appendChild(row));
            }
        </script>
    </div>
@endsection
