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
                <h2 class="text-xl font-roboto-slab text-green-gs">Genres</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="genres" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="genres">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="genres">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse font-roboto-slab">
                <thead>
                    <tr class="bg-gray-200 rounded-t-sm">
                        <th class="p-2 border   ">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Slug</th>
                        <th class="p-2 border">Actif</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="genres-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Orientation Sexuelle -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="orientationSexuelle">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Orientation Sexuelle</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="orientationSexuelle" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="orientationSexuelle">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="orientationSexuelle">
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
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="orientationSexuelle-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Silhouette -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="silhouette">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Silhouette</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="silhouette" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="silhouette">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="silhouette">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="silhouette-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Catégories -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="catégories">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Catégories</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="categories" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="categories">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="categories">
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
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="categories-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Nombre de Filles -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="nombre de filles">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Nombre de Filles</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="nombreFilles" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="nombreFilles">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="nombreFilles">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="nombreFilles-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Pratiques Sexuelles -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="pratiques sexuelles">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Pratiques Sexuelles</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="pratiquesSexuelles" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="pratiquesSexuelles">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="pratiquesSexuelles">
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
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="pratiquesSexuelles-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Couleurs des Yeux -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="couleurs des yeux">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Couleurs des Yeux</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="couleursYeux" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="couleursYeux">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="couleursYeux">
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
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="couleursYeux-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Couleurs des Cheveux -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="couleurs des cheveux">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Couleurs des Cheveux</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="couleursCheveux" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="couleursCheveux">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="couleursCheveux">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="couleursCheveux-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Mensurations -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="mensurations">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Mensurations</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="mensurations" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="mensurations">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="mensurations">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="mensurations-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Poitrines -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="poitrines">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Poitrines</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="poitrines" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="poitrines">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="poitrines">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="poitrines-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Pubis -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="pubis">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Pubis</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="pubis" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="pubis">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="pubis">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="pubis-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Tatouages -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="tatouages">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Tatouages</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="tatouages" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="tatouages">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="tatouages">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="tatouages-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Mobilités -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="mobilités">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">Mobilités</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="mobilites" placeholder="Rechercher...">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="mobilites">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="mobilites">
                        Ajouter
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Nom (FR)</th>
                        <th class="p-2 border">Utilisateurs</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="mobilites-table-body"></tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal pour ajouter/modifier -->
<div id="modal" class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h3 id="modal-title" class="text-lg font-bold mb-4">Ajouter un élément</h3>
        <form id="modal-form">
            <div class="space-y-4">
                <input type="hidden" id="modal-id">
                <input type="hidden" id="modal-type">
                <div>
                    <label class="block">Nom (FR)</label>
                    <input type="text" id="modal-nom-fr" class="w-full p-2 border rounded font-roboto-slab ring-green-gs">
                </div>
                <div id="modal-categories" class="hidden flex flex-wrap gap-4">
                    <!-- Bouton radio pour "Escort" -->
                    <div class="flex items-center gap-2">
                        <input
                            type="radio"
                            id="modal-escort-radio"
                            name="modal-category"
                            class="w-5 h-5 text-green-gs rounded focus:ring-green-gs focus:ring-2"
                        >
                        <label for="modal-escort-radio" class="text-gray-700 font-medium cursor-pointer">
                            Escort
                        </label>
                    </div>
                    <!-- Bouton radio pour "Salon" -->
                    <div class="flex items-center gap-2">
                        <input
                            type="radio"
                            id="modal-salon-radio"
                            name="modal-category"
                            class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 focus:ring-2"
                        >
                        <label for="modal-salon-radio" class="text-gray-700 font-medium cursor-pointer">
                            Salon
                        </label>
                    </div>
                </div>


                <div id="modal-extra-fields"></div>
            </div>
            <div class="flex justify-end mt-4 space-x-2">
                <button type="button" id="modal-cancel" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                <button type="submit" class="px-3 py-1 bg-green-gs hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer font-roboto-slab text-white rounded">Enregistrer</button>
            </div>
        </form>
    </div>
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

    /* Conteneur du bouton (position relative pour la tooltip) */
.tooltip-container {
    position: relative;
    display: inline-block;
}

/* Texte de la tooltip (caché par défaut) */
.tooltip-container .tooltip-text {
    visibility: hidden;
    width: 200px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 4px;
    padding: 6px 10px;
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Position au-dessus du bouton */
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s, visibility 0.3s;
    font-size: 14px;
    line-height: 1.4;
}

/* Afficher la tooltip au survol */
.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}

/* Style pour les boutons désactivés */
.tooltip-container[disabled] {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Flèche de la tooltip (optionnel) */
.tooltip-container .tooltip-text::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}

</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration de Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000",
        };

        let locale = @json(app()->getLocale());
        let currentData = {};
        let allTableData = {};
        let isSubmitting = false; // Flag pour éviter les soumissions multiples

        // Mappage des champs à afficher pour chaque type de tableau
        const fieldsMap = {
            'genres': ['id', 'name.' + locale, 'slug', 'is_active', 'users_count'],
            'orientationSexuelle': ['id', 'name.' + locale, 'slug', 'is_active', 'users_count'],
            'silhouette': ['id', 'name.' + locale, 'users_count'],
            'categories': ['id', 'nom.' + locale, 'display_name', 'type', 'users_count'],
            'nombreFilles': ['id', 'name.' + locale, 'users_count'],
            'pratiquesSexuelles': ['id', 'name.' + locale, 'slug', 'is_active', 'users_count'],
            'couleursYeux': ['id', 'name.' + locale, 'slug', 'is_active', 'users_count'],
            'couleursCheveux': ['id', 'name.' + locale, 'users_count'],
            'mensurations': ['id', 'name.' + locale, 'users_count'],
            'poitrines': ['id', 'name.' + locale, 'users_count'],
            'pubis': ['id', 'name.' + locale, 'users_count'],
            'tatouages': ['id', 'name.' + locale, 'users_count'],
            'mobilites': ['id', 'name.' + locale, 'users_count'],
        };

        // Récupère les données
        async function fetchDropdownData() {
            try {
                const response = await fetch('{{ route('dropdown.data.admin') }}');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                currentData = await response.json();
                Object.keys(currentData).forEach(key => {
                    allTableData[key] = [...currentData[key]];
                });
                renderTables();
                setupEventListeners();
            } catch (error) {
                console.error('Error loading dropdown data:', error);
                toastr.error("Erreur lors du chargement des données.");
            }
        }

        // Affiche les tableaux
        function renderTables() {
            Object.keys(fieldsMap).forEach(type => {
                renderTable(type, currentData[type], fieldsMap[type]);
            });
        }


        function renderTable(type, data, fields) {
            const tbody = document.getElementById(`${type}-table-body`);
            if (!tbody) return;
            tbody.innerHTML = '';
            if (!data) return;
            data.forEach(item => {
                const tr = document.createElement('tr');
                fields.forEach(field => {
                    const td = document.createElement('td');
                    td.className = 'p-2 border';
                    const keys = field.split('.');
                    let value = item;
                    keys.forEach(key => value = value?.[key]);
                    td.textContent = value ?? '';
                    tr.appendChild(td);
                });
                const actionsTd = document.createElement('td');
                actionsTd.className = 'p-2 border space-x-2';

                // Bouton Supprimer
                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'px-2 py-1 bg-red-500 text-white rounded delete-btn';
                deleteBtn.setAttribute('data-type', type);
                deleteBtn.setAttribute('data-id', item.id);
                deleteBtn.innerHTML = '<i class="fa-solid fa-trash"></i>';

                if (item.users_count > 0) {
                    deleteBtn.disabled = true;
                    deleteBtn.classList.add('tooltip-container');
                    const tooltipText = document.createElement('span');
                    tooltipText.className = 'tooltip-text';
                    tooltipText.textContent = "Impossible de supprimer : des utilisateurs sont associés à cet élément.";
                    deleteBtn.appendChild(tooltipText);
                }

                // Bouton Modifier
                const editBtn = document.createElement('button');
                editBtn.className = 'px-2 py-1 bg-yellow-500 text-white rounded edit-btn tooltip-container';
                editBtn.setAttribute('data-type', type);
                editBtn.setAttribute('data-id', item.id);
                editBtn.innerHTML = '<i class="fa-solid fa-pencil"></i>';

                const editTooltip = document.createElement('span');
                editTooltip.className = 'tooltip-text';
                editTooltip.textContent = "Modifier cet élément";
                editBtn.appendChild(editTooltip);

                actionsTd.appendChild(deleteBtn);
                actionsTd.appendChild(editBtn);
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
                currentData[type] = allTableData[type].filter(item => {
                    return Object.values(item).some(
                        val => String(val).toLowerCase().includes(term)
                    );
                });
            }
            renderTable(type, currentData[type], fieldsMap[type]);
        }

        // Filtre les sections en fonction de la recherche globale
        function filterSections(searchTerm) {
            const term = searchTerm.toLowerCase();
            document.querySelectorAll('.table-section').forEach(section => {
                const sectionName = section.getAttribute('data-section');
                if (sectionName.toLowerCase().includes(term)) {
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
            if(type === 'categories'){
                document.getElementById('modal-categories').classList.remove('hidden');
            }else{
                document.getElementById('modal-categories').classList.add('hidden');
            }
            document.getElementById('modal-title').textContent = `Ajouter un nouveau`;
            document.getElementById('modal').classList.remove('hidden');
        }

        // Ouvre la modale pour modifier
        function openEditModal(type, id) {
            document.getElementById('modal-type').value = type;
            document.getElementById('modal-id').value = id;
            const item = allTableData[type].find(i => i.id == id);
            if (!item) {
                toastr.error("Élément non trouvé.");
                return;
            }
            document.getElementById('modal-nom-fr').value = type === 'categories' ? item?.nom?.fr ?? '' : item?.name?.fr ?? '';
            if (type === 'categories') {
                document.getElementById('modal-categories').classList.remove('hidden');
                document.getElementById('modal-escort-radio').checked = item.type === 'escort';
                document.getElementById('modal-salon-radio').checked = item.type === 'salon';
            } else {
                document.getElementById('modal-categories').classList.add('hidden');
                document.getElementById('modal-extra-fields').innerHTML = '';
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
                if (isSubmitting) return;
                isSubmitting = true;
                fetch(`/admin/dropdown/${type}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur lors de la suppression.');
                    toastr.success('Suppression réussie !');
                    fetchDropdownData();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    toastr.error('Une erreur est survenue.');
                })
                .finally(() => {
                    isSubmitting = false;
                });
            }
        }

        // Efface la recherche dans un champ spécifique
        function clearSearch(table) {
            const input = document.querySelector(`.search-input[data-table="${table}"]`);
            input.value = '';
            currentData[table] = [...allTableData[table]];
            renderTable(table, currentData[table], fieldsMap[table]);
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
            document.getElementById('modal-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                if (isSubmitting) return;
                isSubmitting = true;

                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.textContent = "En cours...";

                const type = document.getElementById('modal-type').value;
                const id = document.getElementById('modal-id').value;
                const nomFr = document.getElementById('modal-nom-fr').value;
                let categoryType = '';
                if(type === 'categories'){
                    const radioEscort = document.getElementById('modal-escort-radio').checked;
                    const radioSalon = document.getElementById('modal-salon-radio').checked;
                    categoryType = radioEscort ? 'escort' : radioSalon ? 'salon' : '';
                }
                const url = id ? `/admin/dropdown/${type}/${id}` : `/admin/dropdown/${type}`;
                const method = id ? 'PUT' : 'POST';
                const dataForm = {
                    'name': nomFr,
                    'slug': nomFr.toLowerCase().replace(/ /g, '-'),
                    'is_active': true,
                    'locale': locale,
                };
                if(type === 'categories'){
                    dataForm['display_name'] = nomFr.toLowerCase().replace(/ /g, '-');
                    dataForm['type'] = categoryType;
                }

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify(dataForm),
                    });
                    if (!response.ok) throw new Error('Erreur lors de l\'enregistrement.');
                    const data = await response.json();
                    toastr.success(id ? 'Modification réussie !' : 'Ajout réussi !');
                    closeModal();
                    await fetchDropdownData();
                } catch (error) {
                    console.error('Erreur:', error);
                    toastr.error('Une erreur est survenue.');
                } finally {
                    isSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.textContent = id ? "Modifier" : "Ajouter";
                }
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
