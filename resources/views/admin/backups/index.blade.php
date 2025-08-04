@extends('layouts.admin')

@section('admin-content')
<div class="w-full bg-gray-100 min-h-screen p-5">
    <div class="w-full  p-5">
        <h1 class="text-3xl font-bold text-gray-800">Paramètres</h1>
    </div>

    <div class="w-full p-5 mt-5 space-y-5">
        <!-- Sauvegardes Section -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Sauvegardes</h2>
                <button onclick="openModal('backupModal')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                    Sauvegarder
                </button>
            </div>
            <div class="overflow-y-auto max-h-96">
                <!-- Tableau des sauvegardes -->
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Taille DB</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Taille Storage</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Source</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Restaurer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($backupsFiles as $backupFile)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $backupFile->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $backupFile->getFormattedSizeAttribute($backupFile->size_db) }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $backupFile->getFormattedSizeAttribute($backupFile->size_storage) }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $backupFile->metadata['source'] }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $backupFile->created_at }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $backupFile->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $backupFile->status == 'completed' ? 'Réussie' : 'Échouée' }}
                                    </span>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200 flex space-x-2">
                                    <form action="{{ route('backups.destroy', $backupFile->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette sauvegarde ? Cette action est irréversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('backups.download', $backupFile->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir télécharger cette sauvegarde ?');">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </button>
                                    </form>
                                  
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <button type="button" class="text-green-500 hover:text-green-700 focus:outline-none" onclick="openModalRestauration('restoreModal', {{ $backupFile->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </td>
                      
                            </tr>
                        @endforeach
                        @if ($backupsFiles->isEmpty())
                            <tr>
                                <td colspan="7" class="py-2 px-4 mt-5 text-center">Aucune sauvegarde trouvée.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Restauration Section -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Restauration</h2>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="file-upload">
                    Télécharger un fichier de sauvegarde
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="file-upload" type="file">
            </div>
            <div class="overflow-y-auto max-h-96">
                <!-- Liste des fichiers de restauration -->
                <ul class="space-y-2">
                    <li class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <div>
                            <span class="font-medium text-gray-800">backup_20231001.sql</span>
                            <span class="text-sm text-gray-500"> - 10 Mo</span>
                        </div>
                        <button onclick="openModal('restoreModal')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                            Restaurer
                        </button>
                    </li>
                    <li class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <div>
                            <span class="font-medium text-gray-800">backup_20230930.sql</span>
                            <span class="text-sm text-gray-500"> - 9.5 Mo</span>
                        </div>
                        <button onclick="openModal('restoreModal')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                            Restaurer
                        </button>
                    </li>
                    <li class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <div>
                            <span class="font-medium text-gray-800">backup_20230929.sql</span>
                            <span class="text-sm text-gray-500"> - 9 Mo</span>
                        </div>
                        <button  class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                            Restaurer
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de sauvegarde -->
    <div  id="backupModal"  class="bg-black/50 w-full h-full absolute top-0 left-0 z-50 hidden">
    <div class="fixed inset-0  bg-opacity-50 flex justify-center items-center ">
    <div class="bg-white p-5 rounded-lg shadow-lg w-96">
        <div class="text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmation de Sauvegarde</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir effectuer une sauvegarde maintenant ?</p>
            </div>
            <div class="mt-4  flex justify-center flex-row space-x-4">
                <button id="cancelBackup" onclick="closeModal('backupModal')" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Annuler
                </button>
                <form action="{{ route('backups.create') }}" method="POST" class="w-full" >
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class=" px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                        Confirmer
                                        </button>
                                    </form>
            </div>
        </div>
    </div>
    </div>
</div>


    <!-- Modal de confirmation de restauration -->
    <div  id="restoreModal"  class="bg-black/50 w-full h-full absolute top-0 left-0 z-50 hidden">
    <div class="fixed inset-0  bg-opacity-50 flex justify-center items-center ">
    <div class="bg-white p-5 rounded-lg shadow-lg w-96">
        <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmation de Restauration</h3>
                <div class="mt-2 py-2">
                    <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir restaurer à partir de cette sauvegarde ?</p>
                    <div class="mt-4 text-left">
                        <label for="restorePassword" class="block text-sm font-medium text-gray-700 py-2">Mot de passe pour confirmer la restauration</label>
                        <input type="password" id="restorePassword" placeholder="Mot de passe" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                <div class="mt-4  flex justify-center flex-row space-x-4">
                    <button id="cancelRestore" onclick="closeModal('restoreModal')" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </button>
                    <button type="submit" onclick="confirmRestore()" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Confirmer
                        </button>
                </div>
            </div>
        </div>
    </div>
    </div>


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

        function confirmRestore() {
            const password = document.getElementById('restorePassword').value;
            const id = document.getElementById('restoreModal').dataset.id;
            console.log(id);
            console.log(password);
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
                    alert('Erreur lors de la sauvegarde');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la sauvegarde:', error);
                alert('Erreur lors de la sauvegarde');
            });
        }
    </script>
</div>
@endsection
