@extends('layouts.admin')

@section('admin-content')


@php
use Illuminate\Support\Collection;

$backupsFilesUploaded = collect($backupsFiles)->filter(function($b) {
    return isset($b->metadata['is_uploaded']) && $b->metadata['is_uploaded'] === true;
});

$backupsFilesNoUploaded = collect($backupsFiles)->filter(function($b) {
    return empty($b->metadata['is_uploaded']);
});

// Trouver la sauvegarde la plus récente
$latestBackup = collect($backupsFilesNoUploaded)->sortByDesc('created_at')->first();
@endphp


<div class="w-full bg-gray-100 min-h-screen p-5">
    <div class="w-full  p-5">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('backup.parametres') }}</h1>
    </div>

    <div class="w-full p-5 mt-5 space-y-5">
        <!-- Sauvegardes Section -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">{{ __('backup.backup') }}</h2>
                
                <button onclick="openModal('backupModal')" class="bg-supaGirlRose hover:bg-green-gs text-white px-4 py-2 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                    {{ __('backup.backup') }}
                </button>
            </div>
            <div class="overflow-y-auto max-h-96">
                <!-- Tableau des sauvegardes -->
                <table class="min-w-full bg-white">
                <thead>
    <tr>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.nom') }}</th>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <button onclick="sortTable(1)" class="flex items-center">
               
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 8h18M3 12h18m-9 4h9m-9 4h9m-9-8v8m0-8l4 4m-4-4l-4 4" />
                </svg>
                {{ __('backup.taille_db') }}
            </button>
        </th>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <button onclick="sortTable(2)" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 8h18M3 12h18m-9 4h9m-9 4h9m-9-8v8m0-8l4 4m-4-4l-4 4" />
                </svg>
                {{ __('backup.taille_storage') }}
            </button>
        </th>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.source') }}</th>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <button onclick="sortTable(4)" class="flex items-center">
               
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 8h18M3 12h18m-9 4h9m-9 4h9m-9-8v8m0-8l4 4m-4-4l-4 4" />
                </svg>
                {{ __('backup.date') }}
            </button>
        </th>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.statut') }}</th>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.actions') }}</th>
        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.restaurer') }}</th>
    </tr>
</thead>

                    <tbody>
                       
                        @foreach ($backupsFilesNoUploaded as $backupFile)
                            <tr @if($backupFile->id === $latestBackup->id) class="bg-fieldBg" @endif>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->name }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->getFormattedSizeAttribute($backupFile->size_db) }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->getFormattedSizeAttribute($backupFile->size_storage) }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->metadata['source'] }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->created_at }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $backupFile->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $backupFile->status == 'completed' ? __('backup.statut_success') : __('backup.statut_failed') }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 flex space-x-2">
                                     <!-- Bouton Supprimer -->
                                    <button onclick="openConfirmModal('delete', '{{ route('backups.destroy', $backupFile->id) }}')" class="text-red-500 hover:text-red-700 focus:outline-none py-2" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <!-- Bouton Télécharger -->
                                    <button onclick="openConfirmModal('download', '{{ route('backups.download', $backupFile->id) }}')" class="text-blue-500 hover:text-blue-700 focus:outline-none py-2" title="Télécharger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </button>
                                                                
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <button type="button" class="text-supaGirlRose hover:text-green-700 focus:outline-none" onclick="openModalRestauration('restoreModal', {{ $backupFile->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </td>
                      
                            </tr>
                        @endforeach
                        @if ($backupsFilesNoUploaded->isEmpty())
                            <tr>
                                <td colspan="7" class="py-2 px-4 mt-5 text-center">{{ __('backup.no_backups_found') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Restauration Section -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">{{ __('backup.import') }}</h2>
                <button onclick="openModal('uploadModal')" class="bg-supaGirlRose hover:bg-green-gs text-white px-4 py-2 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                    {{ __('backup.importbtn') }}
                </button>
            </div>
         
            <div class="overflow-y-auto max-h-96">
                <!-- Tableau des sauvegardes -->
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.nom') }}</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.taille_db') }}</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.taille_storage') }}</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.source') }}</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.date') }}</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.statut') }}</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.actions') }}</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">{{ __('backup.restaurer') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach ($backupsFilesUploaded as $backupFile)
                            <tr>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->name }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->getFormattedSizeAttribute($backupFile->size_db) }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->getFormattedSizeAttribute($backupFile->size_storage) }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->metadata['source'] }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">{{ $backupFile->created_at }}</td>
                                <td class="py-2 px-4 text-sm border-b border-gray-200">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $backupFile->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $backupFile->status == 'completed' ? __('backup.statut_success') : __('backup.statut_failed') }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 flex space-x-2">
                                     <!-- Bouton Supprimer -->
                                     <button onclick="openConfirmModal('delete', '{{ route('backups.destroy', $backupFile->id) }}')" class="text-red-500 hover:text-red-700 focus:outline-none py-2" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <!-- Bouton Télécharger -->
                                    <button onclick="openConfirmModal('download', '{{ route('backups.download', $backupFile->id) }}')" class="text-blue-500 hover:text-blue-700 focus:outline-none py-2" title="Télécharger">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200 hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </button>
                                  
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <button type="button" class="text-supaGirlRose hover:text-green-gs focus:outline-none" onclick="openModalRestauration('restoreModal', {{ $backupFile->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </td>
                      
                            </tr>
                        @endforeach
                        @if ($backupsFilesUploaded->isEmpty())
                            <tr>
                                <td colspan="7" class="py-2 px-4 mt-5 text-center">{{ __('backup.no_backups_found') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- Modal de confirmation de sauvegarde -->
<div id="backupModal" class="bg-black/50 w-full h-full fixed top-0 left-0 z-50 hidden">
    <div class="flex justify-center items-center w-full h-full">
        <div class="bg-white p-5 rounded-lg shadow-lg w-96 h-52 relative">

            <!-- Loader animé -->
            <div id="backupLoader" class="w-full h-full flex justify-center items-center flex-col hidden absolute top-0 left-0 bg-white rounded-lg">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-supaGirlRose border-opacity-75"></div>
                <p class="text-sm text-gray-500 mt-5 flex items-center">
                    {{ __('backup.backup_loader') }}<span class="dot-animation ml-1"></span>
                </p>
            </div>

            <!-- Contenu du modal -->
            <div class="text-center" id="backupModalContent">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('backup.confirmation_backup') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">{{ __('backup.confirmation_backup_message') }}</p>
                </div>
                <div class="mt-4 flex justify-center flex-row space-x-4">
                    <button id="cancelBackup" onclick="closeModal('backupModal')" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('backup.cancel') }}
                    </button>
                    <form action="{{ route('backups.create') }}" method="POST" class="w-full" onsubmit="showBackupLoader(event)">
                        @csrf
                        @method('POST')
                        <button type="submit" id="confirmBackupBtn" class="px-4 py-2 bg-green-gs text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-supaGirlRose focus:outline-none focus:ring-2 focus:ring-green-gs">
                            {{ __('backup.confirm') }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="actionConfirmModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 text-center">
        <h2 class="text-lg font-semibold text-gray-800 mb-2" id="confirmModalTitle">{{ __('backup.confirm_action') }}</h2>
        <p class="text-sm text-gray-600 mb-4" id="confirmModalMessage">{{ __('backup.confirmation_backup_message') }}</p>
        <form id="confirmModalForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="confirmModalMethod">
            <div class="flex justify-center space-x-4">
                <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">{{ __('backup.cancel') }}</button>
                <button type="submit" class="px-4 py-2 bg-green-gs text-white rounded hover:bg-supaGirlRose">{{ __('backup.confirm') }}</button>
            </div>
        </form>
    </div>
</div>


   <!-- Modal de confirmation de restauration -->
<div id="restoreModal" data-id="" class="bg-black/50 w-full h-full fixed top-0 left-0 z-50 hidden">
    <div class="flex justify-center items-center w-full h-full">
        <div class="bg-white p-5 rounded-lg shadow-lg w-96 h-72 relative">

            <!-- Loader animé -->
            <div id="restoreLoader" class="w-full h-full flex justify-center items-center flex-col hidden absolute top-0 left-0 bg-white rounded-lg ">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-supaGirlRose border-opacity-75"></div>
                <p class="text-sm text-gray-500 mt-5 flex items-center">
                    {{ __('backup.restore_loader') }}<span class="dot-animation ml-1"></span>
                </p>
            </div>

            <!-- Contenu du modal -->
            <div class="mt-3 text-center" id="restoreModalContent">
                <h3 class="text-lg leading-6 font-medium text-green-gs">{{ __('backup.confirmation_restore') }}</h3>
                <div class="mt-2 py-2">
                    <p class="text-sm text-gray-500">{{ __('backup.confirmation_restore_message') }}</p>
                    <div class="mt-4 text-left">
                        <label for="restorePassword" class="block text-sm font-medium text-gray-700 py-2">{{ __('backup.restore_password') }} <span class="text-red-500">*</span></label>
                        <input type="password" id="restorePassword" placeholder="Mot de passe" class="w-full px-3 py-2 border border-green-gs rounded-md shadow-sm focus:outline-none focus:ring-green-gs focus:border-green-gs">
                    </div>
                </div>
                <div class="mt-4 flex justify-center flex-row space-x-4">
                    <button id="cancelRestore" onclick="closeModal('restoreModal')" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('backup.cancel') }}
                    </button>
                    <button type="submit" id="confirmRestoreBtn" onclick="confirmRestore()" class="px-4 py-2 bg-green-gs text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-supaGirlRose focus:outline-none focus:ring-2 focus:ring-green-gs opacity-50 cursor-not-allowed" disabled>
                        {{ __('backup.confirm') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

    <div id="uploadModal" class="bg-black/50 w-full h-full absolute top-0 left-0 z-50 hidden">
        <div class="fixed inset-0 bg-opacity-50 flex justify-center items-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h3 class="text-lg font-medium leading-6 text-green-gs mb-4">{{ __('backup.import_backup') }}</h3>
                    
                    <form id="restoreForm" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <!-- Database Backup -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                    <h4 class="mt-2 text-sm font-medium text-gray-700">{{ __('backup.import_backup_db') }}</h4>
                                    <p class="mt-1 text-xs text-gray-500">{{ __('backup.import_backup_db_message') }}</p>
                                    <div class="mt-2">
                                        <input type="file" id="dbFile" name="db_file" accept=".sql" class="hidden" required>
                                        <label for="dbFile" class="cursor-pointer text-sm text-green-gs hover:text-green-gs">
                                            {{ __('backup.select_file') }}
                                        </label>
                                        <p id="dbFileName" class="text-xs text-gray-500 mt-1">{{ __('backup.select_file') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Storage Backup -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                    <h4 class="mt-2 text-sm font-medium text-gray-700">{{ __('backup.import_backup_storage') }}</h4>
                                    <p class="mt-1 text-xs text-gray-500">{{ __('backup.import_backup_storage_message') }}</p>
                                    <div class="mt-2">
                                        <input type="file" id="storageFile" name="storage_file" accept=".zip" class="hidden">
                                        <label for="storageFile" class="cursor-pointer text-sm text-green-gs hover:text-green-gs">
                                            {{ __('backup.select_file_storage') }}
                                        </label>
                                        <p id="storageFileName" class="text-xs text-gray-500 mt-1">{{ __('backup.select_file_storage') }}</p>
                                    </div>
                                </div>
                            </div>


                            <!-- Buttons -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="closeModal('uploadModal')" id="cancelUpload"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    {{ __('backup.cancel') }}
                                </button>
                                <button type="submit" disabled
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-gs hover:bg-supaGirlRose focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supaGirlRose opacity-50 cursor-not-allowed">
                                    {{ __('backup.confirm') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
    0%   { content: ''; }
    25%  { content: '.'; }
    50%  { content: '..'; }
    75%  { content: '...'; }
    100% { content: ''; }
}
</style>

    <script>
       

    function validateFileType(file, allowedTypes) {
        const extension = file.name.split('.').pop().toLowerCase();
        return allowedTypes.includes(extension);
    }

    function updateFileUI(inputId, fileNameId, allowedTypes, required = true) {
        const input = document.getElementById(inputId);
        const file = input.files[0];
        const fileNameDisplay = document.getElementById(fileNameId);
        const container = input.closest('.border-dashed');
        const icon = container.querySelector('svg');

        // Reset styles
        container.classList.remove('border-supaGirlRose', 'border-red-500');
        icon.classList.remove('text-supaGirlRose', 'text-red-500');
        icon.classList.add('text-gray-400');

        let isValid = false;

        if (file && validateFileType(file, allowedTypes)) {
            fileNameDisplay.textContent = file.name;
            container.classList.add('border-supaGirlRose');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-supaGirlRose');
            isValid = true;
        } else if (file) {
            input.value = ''; // reset input
            fileNameDisplay.textContent = `❌ {{ __('backup.file_invalid') }} .${allowedTypes.join(' ou .')}`;
            container.classList.add('border-red-500');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-red-500');
        } else {
            fileNameDisplay.textContent = '{{ __('backup.select_file') }}';
        }

        validateRestoreButton();
        return isValid || !required;
    }

    function validateRestoreButton() {
        const dbFile = document.getElementById('dbFile').files[0];
        const storageFile = document.getElementById('storageFile').files[0];
        const restoreBtn = document.querySelector('#restoreForm button[type="submit"]');

        const dbValid = dbFile && validateFileType(dbFile, ['sql']);
        const storageValid = !storageFile || validateFileType(storageFile, ['zip']);

        if (dbValid && storageValid) {
            restoreBtn.disabled = false;
            restoreBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            restoreBtn.disabled = true;
            restoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Bind events
    document.getElementById('dbFile').addEventListener('change', function () {
        updateFileUI('dbFile', 'dbFileName', ['sql'], true);
    });

    document.getElementById('storageFile').addEventListener('change', function () {
        updateFileUI('storageFile', 'storageFileName', ['zip'], false);
    });

    // Handle form submission
    document.getElementById('restoreForm').addEventListener('submit', function(e) {
        e.preventDefault();

            const cancelBtn = document.getElementById('uploadModal').querySelector('button[onclick*="closeModal"]');
            cancelBtn.disabled = true;
            cancelBtn.classList.add('opacity-50', 'cursor-not-allowed');
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Traitement...</span>';
            
            // Submit the form
            fetch('{{ route("backups.restore.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                processData: false,
                contentType: false
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Erreur réseau');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('success', data.message || '{{ __('backup.restore_success') }}');
                    closeModal('uploadModal');
                    // Reload the page to reflect changes
                    console.log(data);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    throw new Error(data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', error.message || '{{ __('backup.restore_failed') }}');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
    });

    // Helper function to show toast messages
    function showToast(type, message) {
        // Implement your toast notification system here
        alert(message); // Simple alert for now, replace with your toast implementation
    }
    </script>



    <script>

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function openModalRestauration(modalId , id) {
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
        body: JSON.stringify({ id, password })
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

        restorePasswordInput.addEventListener('input', function () {
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
        form.onsubmit = function () {
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
