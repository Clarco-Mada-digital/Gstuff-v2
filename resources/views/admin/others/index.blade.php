@extends('layouts.admin')
@section('admin-content')
<div class="w-full bg-gray-100 min-h-screen p-5">
    <div class="w-full p-5">
        <h1 class="text-3xl font-bold text-gray-800">{{ __('others.parametres') }}</h1>
   
        <!-- Champ de recherche global pour les sections -->
        <div class="mb-6 mt-6">
            <div class="relative w-96 ">
                <input type="text" id="global-search" class="p-2 border rounded w-full max-w-md pr-10" placeholder="{{ __('others.searchTable') }}">
                <button id="clear-global-search" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>
        </div>
    </div>
    <!-- Conteneur principal -->
    <div class="space-y-8" id="tables-container">
        <!-- Tableau Genres -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="genres" data-section-translate="{{ __('others.genres') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.genres') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="genres" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="genres">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="genres">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse font-roboto-slab">
                <thead>
                <tr class="bg-gray-200 rounded-t-sm">
                    <th class="p-2 border">
                        <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-link mr-2"></i>{{ __('others.slug') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-toggle-on mr-2"></i>{{ __('others.active') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                    </th>
                </tr>

                </thead>
                <tbody id="genres-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Orientation Sexuelle -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="orientationSexuelle" data-section-translate="{{ __('others.orientationSexuelle') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.orientationSexuelle') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="orientationSexuelle" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="orientationSexuelle">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="orientationSexuelle">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">
                        <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-link mr-2"></i>{{ __('others.slug') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-toggle-on mr-2"></i>{{ __('others.active') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                    </th>
                </tr>
                </thead>
                <tbody id="orientationSexuelle-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Silhouette -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="silhouette" data-section-translate="{{ __('others.silhouette') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.silhouette') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="silhouette" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="silhouette">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="silhouette">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200">
    <th class="p-2 border">
        <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
    </th>
    <th class="p-2 border">
        <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="silhouette-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Catégories -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="catégories" data-section-translate="{{ __('others.categories') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.categories') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="categories" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="categories">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="categories">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">
                        <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-text mr-2"></i>{{ __('others.display_name') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-layer-group mr-2"></i>{{ __('others.type') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                    </th>
                </tr>

                </thead>
                <tbody id="categories-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Nombre de Filles -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="nombre de filles" data-section-translate="{{ __('others.nombreFilles') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.nombreFilles') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="nombreFilles" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="nombreFilles">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="nombreFilles">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">
                        <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                    </th>
                </tr>
                </thead>
                <tbody id="nombreFilles-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Pratiques Sexuelles -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="pratiques sexuelles" data-section-translate="{{ __('others.pratiquesSexuelles') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.pratiquesSexuelles') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="pratiquesSexuelles" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="pratiquesSexuelles">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="pratiquesSexuelles">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-text mr-2"></i>{{ __('others.slug') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-layer-group mr-2"></i>{{ __('others.active') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>Utilisateurs
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="pratiquesSexuelles-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Couleurs des Yeux -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="couleurs des yeux" data-section-translate="{{ __('others.couleursYeux') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.couleursYeux') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="couleursYeux" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="couleursYeux">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="couleursYeux">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-text mr-2"></i>{{ __('others.slug') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-layer-group mr-2"></i>{{ __('others.active') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="couleursYeux-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Couleurs des Cheveux -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="couleurs des cheveux" data-section-translate="{{ __('others.couleursCheveux') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.couleursCheveux') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="couleursCheveux" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="couleursCheveux">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="couleursCheveux">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="couleursCheveux-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Mensurations -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="mensurations" data-section-translate="{{ __('others.mensurations') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.mensurations') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="mensurations" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="mensurations">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="mensurations">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="mensurations-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Poitrines -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="poitrines" data-section-translate="{{ __('others.poitrines') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.poitrines') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="poitrines" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="poitrines">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="poitrines">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="poitrines-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Pubis -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="pubis" data-section-translate="{{ __('others.pubis') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.pubis') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="pubis" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="pubis">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="pubis">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="pubis-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Tatouages -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="tatouages" data-section-translate="{{ __('others.tatouages') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.tatouages') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="tatouages" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="tatouages">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="tatouages">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="tatouages-table-body"></tbody>
            </table>
        </div>
        <!-- Tableau Mobilités -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="mobilités" data-section-translate="{{ __('others.mobilites') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.mobilites') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="mobilites" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="mobilites">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="mobilites">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2 border">
                            <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                        </th>
                        <th class="p-2 border">
                            <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody id="mobilites-table-body"></tbody>
            </table>
        </div>


        <!-- Tableau Services -->
        <div class="bg-white p-4 rounded-lg shadow table-section" data-section="services" data-section-translate="{{ __('others.services') }}">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-roboto-slab text-green-gs">{{ __('others.services') }}</h2>
                <div class="flex space-x-2">
                    <div class="relative">
                        <input type="text" class="p-2 border rounded search-input pr-10 font-roboto-slab ring-green-gs" data-table="services" placeholder="{{ __('others.search') }}">
                        <button class="clear-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-table="services">
                            ✕
                        </button>
                    </div>
                    <button class="px-3 py-1 bg-green-gs text-white rounded hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer add-btn" data-type="services">
                        {{ __('others.add') }}
                    </button>
                </div>
            </div>
            <table class="w-full border-collapse font-roboto-slab">
                <thead>
                <tr class="bg-gray-200 rounded-t-sm">
                    <th class="p-2 border">
                        <i class="fa-solid fa-hashtag mr-2"></i>{{ __('others.id') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-tag mr-2"></i>{{ __('others.name') }}
                    </th>
                   
                
                    <th class="p-2 border">
                        <i class="fa-solid fa-users mr-2"></i>{{ __('others.users') }}
                    </th>
                    <th class="p-2 border">
                        <i class="fa-solid fa-users mr-2"></i>{{ __('others.categories') }}
                    </th>
        
                    <th class="p-2 border">
                        <i class="fa-solid fa-ellipsis-vertical mr-2"></i>{{ __('others.actions') }}
                    </th>
                </tr>

                </thead>
                <tbody id="services-table-body"></tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal pour ajouter/modifier -->
<div id="modal" class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h3 id="modal-title" class="text-lg font-bold mb-4">{{ __('others.addElement') }}</h3>
        <form id="modal-form">
            <div class="space-y-4">
                <input type="hidden" id="modal-id">
                <input type="hidden" id="modal-type">
                <div>
                    <label class="block">{{ __('others.name') }}</label>
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
                            {{ __('others.escort') }}
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
                            {{ __('others.salon') }}
                        </label>
                    </div>
                </div>

                <div id="modal-categories-select" class="hidden flex flex-wrap gap-4">
                    <!-- Bouton radio pour "Escort" -->
                    <div class="flex items-center gap-2">
                        <input
                            type="radio"
                            id="modal-services-radio-escort"
                            name="modal-category"
                            class="w-5 h-5 text-green-gs rounded focus:ring-green-gs focus:ring-2"
                            value="escort"
                        >
                        <label for="modal-services-radio-escort" class="text-gray-700 font-medium cursor-pointer">
                            {{ __('others.escort') }}
                        </label>
                    </div>
                    <!-- Bouton radio pour "Salon" -->
                    <div class="flex items-center gap-2">
                        <input
                            type="radio"
                            id="modal-services-radio-masseuse"
                            name="modal-category"
                            class="w-5 h-5 text-green-gs rounded focus:ring-green-gs focus:ring-2"
                            value="masseuse"
                        >
                        <label for="modal-services-radio-masseuse" class="text-gray-700 font-medium cursor-pointer">
                            {{ __('others.masseuse') }}
                        </label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input
                            type="radio"
                            id="modal-services-radio-dominatrice"
                            name="modal-category"
                            class="w-5 h-5 text-green-gs rounded focus:ring-green-gs focus:ring-2"
                            value="dominatrice"
                        >
                        <label for="modal-services-radio-dominatrice" class="text-gray-700 font-medium cursor-pointer">
                            {{ __('others.dominatrice') }}
                        </label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input
                            type="radio"
                            id="modal-services-radio-transvestite"
                            name="modal-category"
                            class="w-5 h-5 text-green-gs rounded focus:ring-green-gs focus:ring-2"
                            value="transvestite"
                        >
                        <label for="modal-services-radio-transvestite" class="text-gray-700 font-medium cursor-pointer">
                            {{ __('others.transvestite') }}
                        </label>
                    </div>  
                </div>


                <div id="modal-extra-fields"></div>
            </div>
            <div class="flex justify-end mt-4 space-x-2">
                <button type="button" id="modal-cancel" class="px-3 py-1 bg-gray-300 rounded">{{ __('others.cancel') }}</button>
                <button type="submit" class="px-3 py-1 bg-green-gs hover:bg-white hover:text-green-gs border border-green-gs hover:border-green-gs cursor-pointer font-roboto-slab text-white rounded">{{ __('others.save') }}</button>
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
        let dropCategories = [];

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
            'services': ['id', 'nom.' + locale, 'users_count', 'categorie.nom.' + locale],
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
                    if(key === 'dropCategories') {
                        dropCategories = currentData[key];
                    }
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
                    if (field === 'is_active') {
                const tooltipContainer = document.createElement('div');
                tooltipContainer.className = 'tooltip-container inline-block';

                const icon = document.createElement('i');
                icon.className = value
                    ? 'fa-solid fa-circle-check text-green-500'
                    : 'fa-solid fa-circle-xmark text-red-500';

                const tooltipText = document.createElement('span');
                tooltipText.className = 'tooltip-text';
                tooltipText.textContent = value
                    ? "{{ __('others.tooltipActif') }}"
                    : "{{ __('others.tooltipInactif') }}";

                tooltipContainer.appendChild(icon);
                tooltipContainer.appendChild(tooltipText);
                td.appendChild(tooltipContainer);
            } else {
                td.textContent = value ?? '';
            }
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
                    tooltipText.textContent = "{{ __('others.tooltipDelete') }}";
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
                editTooltip.textContent = "{{ __('others.tooltipEdit') }}";
                editBtn.appendChild(editTooltip);

                actionsTd.appendChild(deleteBtn);
                actionsTd.appendChild(editBtn);
                tr.appendChild(actionsTd);
                tbody.appendChild(tr);
            });
        }


        function filterTable(type, searchTerm) {
            if (!searchTerm) {
                currentData[type] = [...allTableData[type]];
            } else {
                const term = searchTerm.toLowerCase();
                currentData[type] = allTableData[type].filter(item => {
                    // On filtre uniquement sur le nom dans la locale actuelle
                    if(type == 'services' || type == 'categories'){
                        const name = item.nom?.[locale]?.toLowerCase() || '';
                        return name.includes(term);
                    }
                    const name = item.name?.[locale]?.toLowerCase() || '';
                    return name.includes(term);
                });
            }
            renderTable(type, currentData[type], fieldsMap[type]);
        }



        // Filtre les sections en fonction de la recherche globale
        function filterSections(searchTerm) {
            const term = searchTerm.toLowerCase();
            document.querySelectorAll('.table-section').forEach(section => {
                const sectionName = section.getAttribute('data-section-translate');
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
            }else if(type === 'services'){
                document.getElementById('modal-categories-select').classList.remove('hidden');

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
            document.getElementById('modal-nom-fr').value = type === 'categories' ? item?.nom?.[locale] ?? '' : item?.name?.[locale] ?? '';
            if (type === 'categories') {
                document.getElementById('modal-categories').classList.remove('hidden');
                document.getElementById('modal-escort-radio').checked = item.type === 'escort';
                document.getElementById('modal-salon-radio').checked = item.type === 'salon';
            } else if (type === 'services') {
                document.getElementById('modal-categories-select')?.classList.remove('hidden');
                document.getElementById('modal-nom-fr').value = item?.nom?.[locale] ?? '';

                const radioEscort = document.getElementById('modal-services-radio-escort');
                const radioMasseuse = document.getElementById('modal-services-radio-masseuse');
                const radioDominatrice = document.getElementById('modal-services-radio-dominatrice');
                const radioTransvestite = document.getElementById('modal-services-radio-transvestite');

                if (radioEscort) radioEscort.checked = item.categorie_id === 1;
                if (radioMasseuse) radioMasseuse.checked = item.categorie_id === 2;
                if (radioDominatrice) radioDominatrice.checked = item.categorie_id === 3;
                if (radioTransvestite) radioTransvestite.checked = item.categorie_id === 4;
            }else {
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
            if (confirm('{{ __("others.confirmdelete") }}')) {
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
                    toastr.success('{{ __("others.successDeleted") }}');
                    fetchDropdownData();
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    toastr.error('{{ __("others.errorDeleted") }}');
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
                let serviceType = '';
                if(type === 'categories'){
                    const radioEscort = document.getElementById('modal-escort-radio').checked;
                    const radioSalon = document.getElementById('modal-salon-radio').checked;
                    categoryType = radioEscort ? 'escort' : radioSalon ? 'salon' : '';
                }

                if (type === 'services') {
                    console.log("type", type);
                    const radioEscort = document.getElementById('modal-services-radio-escort');
                    const radioMasseuse = document.getElementById('modal-services-radio-masseuse');
                    const radioDominatrice = document.getElementById('modal-services-radio-dominatrice');
                    const radioTransvestite = document.getElementById('modal-services-radio-transvestite');

                    if (radioEscort.checked) {
                        serviceType = radioEscort.value;
                    } else if (radioMasseuse.checked) {
                        serviceType = radioMasseuse.value;
                    } else if (radioDominatrice.checked) {
                        serviceType = radioDominatrice.value;
                    } else if (radioTransvestite.checked) {
                        serviceType = radioTransvestite.value;
                    } else {
                        serviceType = null; // ou une valeur par défaut
                    }
                }

                console.log("serviceType", serviceType);

                const url = id ? `/admin/dropdown/${type}/${id}` : `/admin/dropdown/${type}`;
                const method = id ? 'PUT' : 'POST';
                const dataForm = {
                    'name': nomFr,
                    'slug': nomFr.toLowerCase().replace(/ /g, '-'),
                    'is_active': true,
                    'locale': locale,
                };
                if(type === 'categories'){
                    dataForm['display_name'] = slugify(nomFr);
                    dataForm['type'] = categoryType;
                }
                if(type === 'services'){
                    dataForm['category_type'] = serviceType;
                }

                console.log("dataForm", dataForm);
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
                    toastr.success(id ? '{{ __("others.successUpdated") }}' : '{{ __("others.successAdded") }}');
                    closeModal();
                    await fetchDropdownData();
                } catch (error) {
                    console.error('Erreur:', error);
                    toastr.error('{{ __("others.errorAdded") }}');
                } finally {
                    isSubmitting = false;
                    submitBtn.disabled = false;
                    submitBtn.textContent = id ? '{{ __("others.edit") }}' : '{{ __("others.add") }}';
                }
            });

            function slugify(nomFr) {
                return nomFr
                    .normalize('NFD')                      // Sépare les lettres des accents
                    .replace(/[\u0300-\u036f]/g, '')       // Supprime les accents
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')          // Supprime les caractères spéciaux
                    .trim()
                    .replace(/\s+/g, '-')                  // Remplace les espaces par des tirets
                    .replace(/-+/g, '-');                  // Évite les tirets doublés
            }


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
