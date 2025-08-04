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
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Heure</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">2023-10-01</td>
                            <td class="py-2 px-4 border-b border-gray-200">12:00</td>
                            <td class="py-2 px-4 border-b border-gray-200">Réussie</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">2023-09-30</td>
                            <td class="py-2 px-4 border-b border-gray-200">11:30</td>
                            <td class="py-2 px-4 border-b border-gray-200">Réussie</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">2023-09-29</td>
                            <td class="py-2 px-4 border-b border-gray-200">10:15</td>
                            <td class="py-2 px-4 border-b border-gray-200">Échouée</td>
                        </tr>
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
                        <button onclick="openModal('restoreModal')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
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
                <button id="confirmBackup" onclick="confirmBackup()" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    Confirmer
                </button>
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
                    <button id="confirmRestore" onclick="confirmRestore()" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
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

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function confirmRestore() {
            const password = document.getElementById('restorePassword').value;
            if (password) {
                alert('Restauration confirmée avec le mot de passe : ' + password);
                closeModal('restoreModal');
            } else {
                alert('Veuillez entrer un mot de passe pour confirmer la restauration.');
            }
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
