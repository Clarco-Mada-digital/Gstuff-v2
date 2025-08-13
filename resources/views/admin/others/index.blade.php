@extends('layouts.admin')
@section('admin-content')
<div class="w-full bg-gray-100 min-h-screen p-5">
    <div class="w-full p-5">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('others.parametres') }}</h1>
        <p class="text-gray-600 mb-6">Gérez les paramètres sous forme de tableaux.</p>
        <!-- Champ de recherche global pour les sections -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" id="global-search" class="p-2 border rounded w-full max-w-md pr-10" placeholder="Rechercher un tableau (ex: genre, silhouette)...">
                <button id="clear-global-search" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
        </div>
    </div>

    <!-- Conteneur principal -->
    <div class="space-y-8" id="tables-container">
        <!-- Tableau Genres -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="genres">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Genres</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="genres" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="genres">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="genres">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Slug</th>
                        <th class="p-2 border">Actif</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="genres-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Orientation Sexuelle -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="orientation sexuelle">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Orientation Sexuelle</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="orientationSexuelle" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="orientationSexuelle">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="orientationSexuelle">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Slug</th>
                        <th class="p-2 border">Actif</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="orientationSexuelle-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Silhouette -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="silhouette">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Silhouette</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="silhouette" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="silhouette">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="silhouette">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="silhouette-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Catégories -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="catégories">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Catégories</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="categories" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="categories">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="categories">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Display Name</th>
                        <th class="p-2 border">Type</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="categories-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Nombre de Filles -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="nombre de filles">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Nombre de Filles</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="nombreFilles" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="nombreFilles">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="nombreFilles">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="nombreFilles-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Pratiques Sexuelles -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="pratiques sexuelles">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Pratiques Sexuelles</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="pratiquesSexuelles" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="pratiquesSexuelles">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="pratiquesSexuelles">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Slug</th>
                        <th class="p-2 border">Actif</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="pratiquesSexuelles-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Origines -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="origines">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Origines</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="origines" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="origines">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="origines">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Valeur</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="origines-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Langues -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="langues">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Langues</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="langues" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="langues">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="langues">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Valeur</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="langues-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Couleurs des Yeux -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="couleurs des yeux">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Couleurs des Yeux</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="couleursYeux" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="couleursYeux">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="couleursYeux">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Slug</th>
                        <th class="p-2 border">Actif</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="couleursYeux-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Couleurs des Cheveux -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="couleurs des cheveux">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Couleurs des Cheveux</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="couleursCheveux" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="couleursCheveux">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="couleursCheveux">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="couleursCheveux-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Mensurations -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="mensurations">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Mensurations</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="mensurations" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="mensurations">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="mensurations">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="mensurations-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Poitrines -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="poitrines">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Poitrines</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="poitrines" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="poitrines">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="poitrines">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="poitrines-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Tailles de Poitrine -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="tailles de poitrine">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Tailles de Poitrine</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="taillesPoitrine" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="taillesPoitrine">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="taillesPoitrine">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Valeur</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="taillesPoitrine-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Pubis -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="pubis">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Pubis</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="pubis" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="pubis">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="pubis">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="pubis-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Tatouages -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="tatouages">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Tatouages</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="tatouages" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="tatouages">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="tatouages">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="tatouages-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Mobilités -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="mobilités">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Mobilités</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="mobilites" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="mobilites">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="mobilites">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="mobilites-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Tarifs -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="tarifs">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Tarifs</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="tarifs" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="tarifs">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="tarifs">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Valeur (CHF)</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="tarifs-table-body"></tbody>
            </table>
        </div>

        <!-- Tableau Paiements -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="moyens de paiement">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Moyens de Paiement</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10" data-table="paiements" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="paiements">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 add-btn" data-type="paiements">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">Valeur</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="paiements-table-body"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pour ajouter/modifier -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h3 id="modal-title" class="text-lg font-bold mb-4">Ajouter un élément</h3>
        <form id="modal-form">
            <div class="space-y-4">
                <input type="hidden" id="modal-id">
                <input type="hidden" id="modal-type">
                <div>
                    <label class="block">Nom (FR)</label>
                    <input type="text" id="modal-nom-fr" class="w-full p-2 border rounded">
                </div>
                <div id="modal-extra-fields"></div>
            </div>
            <div class="flex justify-end mt-4 space-x-2">
                <button type="button" id="modal-cancel" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Enregistrer</button>
            </div>
        </form>
    </div>

<style>
    .shadow {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    table {
        width: 100%;
    }
    th, td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
    }
    #modal {
        z-index: 50;
    }
    .search-input {
        min-width: 200px;
    }
    .table-section {
        display: block;
    }
    .table-section.hidden {
        display: none;
    }
    .clear-search {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentData = {};
        let allTableData = {}; // Stocke toutes les données pour la recherche

        // Récupère les données
        async function fetchDropdownData() {
            try {
                const response = await fetch('{{ route('dropdown.data') }}');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                currentData = await response.json();
                // Sauvegarde une copie des données pour la recherche
                Object.keys(currentData).forEach(key => {
                    allTableData[key] = [...currentData[key]];
                });
                renderTables();
                setupEventListeners();
            } catch (error) {
                console.error('Error loading dropdown data:', error);
                alert("Erreur lors du chargement des données.");
            }
        }

        // Affiche les tableaux
        function renderTables() {
            renderTable('genres', currentData.genres, ['id', 'name.fr', 'slug', 'is_active']);
            renderTable('orientationSexuelle', currentData.oriantationSexuelles, ['id', 'name.fr', 'slug', 'is_active']);
            renderTable('silhouette', currentData.silhouette, ['id', 'name.fr']);
            renderTable('categories', currentData.categories, ['id', 'nom.fr', 'display_name', 'type']);
            renderTable('nombreFilles', currentData.nombreFilles, ['id', 'name.fr']);
            renderTable('pratiquesSexuelles', currentData.pratiquesSexuelles, ['id', 'name.fr', 'slug', 'is_active']);
            renderSimpleTable('origines', currentData.origines);
            renderSimpleTable('langues', currentData.langues);
            renderTable('couleursYeux', currentData.couleursYeux, ['id', 'name.fr', 'slug', 'is_active']);
            renderTable('couleursCheveux', currentData.couleursCheveux, ['id', 'name.fr']);
            renderTable('mensurations', currentData.mensurations, ['id', 'name.fr']);
            renderTable('poitrines', currentData.poitrines, ['id', 'name.fr']);
            renderSimpleTable('taillesPoitrine', currentData.taillesPoitrine);
            renderTable('pubis', currentData.pubis, ['id', 'name.fr']);
            renderTable('tatouages', currentData.tatouages, ['id', 'name.fr']);
            renderTable('mobilites', currentData.mobilites, ['id', 'name.fr']);
            renderSimpleTable('tarifs', currentData.tarifs);
            renderSimpleTable('paiements', currentData.paiements);
        }

        // Affiche un tableau avec des objets
        function renderTable(type, data, fields) {
            const tbody = document.getElementById(`${type}-table-body`);
            tbody.innerHTML = '';
            data.forEach(item => {
                const tr = document.createElement('tr');
                fields.forEach(field => {
                    const td = document.createElement('td');
                    td.className = 'p-2 border';
                    const keys = field.split('.');
                    let value = item;
                    keys.forEach(key => value = value[key]);
                    td.textContent = value;
                    tr.appendChild(td);
                });
                const actionsTd = document.createElement('td');
                actionsTd.className = 'p-2 border space-x-2';
                actionsTd.innerHTML = `
                    <button class="px-2 py-1 bg-yellow-500 text-white rounded edit-btn" data-type="${type}" data-id="${item.id}">Modifier</button>
                    <button class="px-2 py-1 bg-red-500 text-white rounded delete-btn" data-type="${type}" data-id="${item.id}">Supprimer</button>
                `;
                tr.appendChild(actionsTd);
                tbody.appendChild(tr);
            });
        }

        // Affiche un tableau avec des valeurs simples
        function renderSimpleTable(type, data) {
            const tbody = document.getElementById(`${type}-table-body`);
            tbody.innerHTML = '';
            data.forEach(item => {
                const tr = document.createElement('tr');
                const tdValue = document.createElement('td');
                tdValue.className = 'p-2 border';
                tdValue.textContent = item;
                tr.appendChild(tdValue);
                const actionsTd = document.createElement('td');
                actionsTd.className = 'p-2 border space-x-2';
                actionsTd.innerHTML = `
                    <button class="px-2 py-1 bg-yellow-500 text-white rounded edit-btn" data-type="${type}" data-id="${item}">Modifier</button>
                    <button class="px-2 py-1 bg-red-500 text-white rounded delete-btn" data-type="${type}" data-id="${item}">Supprimer</button>
                `;
                tr.appendChild(actionsTd);
                tbody.appendChild(tr);
            });
        }

        // Filtre un tableau en fonction de la recherche
        function filterTable(type, searchTerm) {
            if (!searchTerm) {
                currentData[type] = [...allTableData[type]];
            } else {
                const term = searchTerm.toLowerCase();
                if (['origines', 'langues', 'taillesPoitrine', 'tarifs', 'paiements'].includes(type)) {
                    currentData[type] = allTableData[type].filter(item =>
                        item.toString().toLowerCase().includes(term)
                    );
                } else {
                    currentData[type] = allTableData[type].filter(item => {
                        return Object.values(item.name.fr).join('').toLowerCase().includes(term) ||
                               Object.values(item).join('').toLowerCase().includes(term);
                    });
                }
            }
            // Réaffiche le tableau filtré
            if (['origines', 'langues', 'taillesPoitrine', 'tarifs', 'paiements'].includes(type)) {
                renderSimpleTable(type, currentData[type]);
            } else {
                const fields = getFieldsForType(type);
                renderTable(type, currentData[type], fields);
            }
        }

        // Retourne les champs à afficher pour un type donné
        function getFieldsForType(type) {
            const fieldsMap = {
                'genres': ['id', 'name.fr', 'slug', 'is_active'],
                'orientationSexuelle': ['id', 'name.fr', 'slug', 'is_active'],
                'silhouette': ['id', 'name.fr'],
                'categories': ['id', 'nom.fr', 'display_name', 'type'],
                'nombreFilles': ['id', 'name.fr'],
                'pratiquesSexuelles': ['id', 'name.fr', 'slug', 'is_active'],
                'couleursYeux': ['id', 'name.fr', 'slug', 'is_active'],
                'couleursCheveux': ['id', 'name.fr'],
                'mensurations': ['id', 'name.fr'],
                'poitrines': ['id', 'name.fr'],
                'pubis': ['id', 'name.fr'],
                'tatouages': ['id', 'name.fr'],
                'mobilites': ['id', 'name.fr'],
            };
            return fieldsMap[type] || [];
        }

        // Filtre les sections en fonction de la recherche globale
        function filterSections(searchTerm) {
            const term = searchTerm.toLowerCase();
            document.querySelectorAll('.table-section').forEach(section => {
                const sectionName = section.getAttribute('data-section');
                if (sectionName.includes(term)) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        }

        // Ouvre la modale pour ajouter
        function openAddModal(type) {
            document.getElementById('modal-type').value = type;
            document.getElementById('modal-id').value = '';
            document.getElementById('modal-nom-fr').value = '';
            document.getElementById('modal-extra-fields').innerHTML = '';
            document.getElementById('modal-title').textContent = `Ajouter un${type === 'origines' || type === 'langues' || type === 'taillesPoitrine' || type === 'tarifs' || type === 'paiements' ? 'e ' : ' '}${type}`;
            document.getElementById('modal').classList.remove('hidden');
        }

        // Ouvre la modale pour modifier
        function openEditModal(type, id) {
            document.getElementById('modal-type').value = type;
            document.getElementById('modal-id').value = id;
            if (['origines', 'langues', 'taillesPoitrine', 'tarifs', 'paiements'].includes(type)) {
                document.getElementById('modal-nom-fr').value = id;
            } else {
                const item = allTableData[type].find(i => i.id == id);
                document.getElementById('modal-nom-fr').value = item.name.fr;
            }
            document.getElementById('modal-title').textContent = `Modifier ${type} (ID: ${id})`;
            document.getElementById('modal').classList.remove('hidden');
        }

        // Ferme la modale
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        // Supprime un élément
        function deleteItem(type, id) {
            if (confirm('Voulez-vous vraiment supprimer cet élément ?')) {
                console.log(`Supprimer ${type} avec ID: ${id}`);
                alert('Fonctionnalité de suppression à implémenter.');
            }
        }

        // Efface la recherche dans un champ spécifique
        function clearSearch(table) {
            const input = document.querySelector(`.search-input[data-table="${table}"]`);
            input.value = '';
            currentData[table] = [...allTableData[table]];
            if (['origines', 'langues', 'taillesPoitrine', 'tarifs', 'paiements'].includes(table)) {
                renderSimpleTable(table, currentData[table]);
            } else {
                const fields = getFieldsForType(table);
                renderTable(table, currentData[table], fields);
            }
        }

        // Efface la recherche globale
        function clearGlobalSearch() {
            document.getElementById('global-search').value = '';
            filterSections('');
        }

        // Configure les écouteurs d'événements
        function setupEventListeners() {
            // Ajouter
            document.querySelectorAll('.add-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const type = btn.getAttribute('data-type');
                    openAddModal(type);
                });
            });

            // Modifier
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const type = btn.getAttribute('data-type');
                    const id = btn.getAttribute('data-id');
                    openEditModal(type, id);
                });
            });

            // Supprimer
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const type = btn.getAttribute('data-type');
                    const id = btn.getAttribute('data-id');
                    deleteItem(type, id);
                });
            });

            // Annuler
            document.getElementById('modal-cancel').addEventListener('click', closeModal);

            // Soumettre le formulaire
            document.getElementById('modal-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const type = document.getElementById('modal-type').value;
                const id = document.getElementById('modal-id').value;
                const nomFr = document.getElementById('modal-nom-fr').value;
                console.log(`Enregistrer ${type}:`, { id, nomFr });
                alert('Fonctionnalité d\'enregistrement à implémenter.');
                closeModal();
            });

            // Recherche dans un tableau
            document.querySelectorAll('.search-input').forEach(input => {
                input.addEventListener('input', (e) => {
                    const type = e.target.getAttribute('data-table');
                    filterTable(type, e.target.value);
                });
            });

            // Effacer la recherche dans un tableau
            document.querySelectorAll('.clear-search').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const table = e.target.getAttribute('data-table');
                    clearSearch(table);
                });
            });

            // Recherche globale des sections
            document.getElementById('global-search').addEventListener('input', (e) => {
                filterSections(e.target.value);
            });

            // Effacer la recherche globale
            document.getElementById('clear-global-search').addEventListener('click', clearGlobalSearch);
        }

        // Charge les données au démarrage
        fetchDropdownData();
    });
</script>
@endsection
