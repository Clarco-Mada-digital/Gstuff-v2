@extends('layouts.admin')

@section('page_title')
    {{__('admin_dashboard.admin_dashboard')}}
@endsection

@section('admin-content')
<div class="min-h-screen bg-gray-100">

    <!-- Main content -->
    <div class="pt-16">
        <!-- Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <div class="flex sm:flex-row items-start space-y-2 sm:space-y-0 sm:space-x-4 mb-6">
                <!-- Filtre par statut -->
                <div class="relative w-full sm:w-48">
                    <select x-model="filters.status"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                        <option value="">{{__('admin_dashboard.all_statuses')}}</option>
                        <option value='published'>{{__('admin_dashboard.published')}}</option>
                        <option value='unpublished'>{{__('admin_dashboard.draft')}}</option>
                        {{-- <option value="archived">{{__('admin_dashboard.archived')}}</option> --}}
                    </select>
                </div>

                <!-- Barre de recherche -->
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input x-model="filters.search"
                           type="text"
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="{{__('admin_dashboard.search_articles')}}">
                </div>

                <!-- Bouton reset -->
                <button @click="resetFilters()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                    {{__('admin_dashboard.reset')}}
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">{{__('admin_dashboard.articles')}}</p>
                            <p class="text-2xl font-semibold" x-text="stats.articles"></p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('articles.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">{{__('admin_dashboard.view_all')}} →</a>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">{{__('admin_dashboard.users')}}</p>
                            <p class="text-2xl font-semibold" x-text="stats.users"></p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12q-1.65 0-2.825-1.175T8 8t1.175-2.825T12 4t2.825 1.175T16 8t-1.175 2.825T12 12m4 8v-6.4q.625.2 1.225.425t1.175.525q.75.375 1.175 1.088T20 17.2v.8q0 .825-.587 1.413T18 20zm-6-3.5v-3.35q.5-.075 1-.112T12 13t1 .038t1 .112v3.35zM4 18v-.8q0-.85.425-1.562T5.6 14.55q.575-.3 1.175-.525T8 13.6V20H6q-.825 0-1.412-.587T4 18"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{route('users.index')}}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">{{__('admin_dashboard.view_all')}} →</a>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-lg font-medium flex items-center">
                                {{__('admin_dashboard.approved_escorts')}}
                            </p>
                            <p class="text-2xl font-semibold" x-text="stats.escorteApproved"></p>
                        </div>
                        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-user-check text-blue-500"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">{{__('admin_dashboard.view_all')}} →</a>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div x-data="{ isEditing: false, distanceMax: stats.distanceMax ?? 0 }">
                        <!-- Affichage -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-lg font-medium flex items-center">
                                    {{__('admin_dashboard.escorts_around')}}
                                </p>
                                <template x-if="!isEditing">
                                    <p class="text-2xl font-semibold">
                                        <span x-text="stats.distanceMax + ' km'"></span>
                                    </p>
                                </template>
                                <template x-if="isEditing">
                                    <input type="number" name="distance_max"
                                        class="text-xl font-semibold border rounded w-32 py-0 px-2"
                                        x-model="stats.distanceMax" />
                                </template>
                            </div>
                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-user-check text-blue-500"></i>
                            </div>
                        </div>

                        <!-- Formulaire -->
                        <form method="POST" action="{{ route('distance.update') }}">
                            @csrf
                            <input type="hidden" name="distance_max" x-model="stats.distanceMax">

                            <div class="mt-4">
                                <button type="button" x-on:click="isEditing = !isEditing"
                                    x-text="isEditing ? '{{__('admin_dashboard.cancel')}}' : '{{__('admin_dashboard.edit')}} →'"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                </button>

                                <button x-show="isEditing" type="submit"
                                    class="text-white bg-blue-600 px-2 py-1 rounded text-sm">
                                    {{__('admin_dashboard.update')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Derniers articles -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <h2 @click="sort.field = 'title'; sort.direction = sort.direction === 'asc' ? 'desc' : 'asc'; sortedArticles()"  class="text-lg font-semibold text-gray-900">{{__('admin_dashboard.recent_articles')}}</h2>
                        <span x-show="sort.field === 'title'" x-text="sort.direction === 'asc' ? '↑' : '↓'" class="ml-1"></span>
                    </div>
                    <a href="{{ route('articles.create') }}" class="text-sm text-blue-600 hover:text-blue-800">+ {{__('admin_dashboard.new_article')}}</a>
                </div>
                <div class="divide-y divide-gray-200">
                    <template x-for="article in filteredArticles()" :key="article.id">
                        <div class="px-6 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <a :href="`{{route('articles.index')}}/${article.id}`" class="font-medium text-gray-900 hover:text-blue-600" x-text="article.title"></a>
                                    <p class="text-sm text-gray-500 mt-1" x-text="article.excerpt"></p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs rounded-full"
                                          :class="{
                                            'bg-green-100 text-green-800': article.status === 'published',
                                            'bg-yellow-100 text-yellow-800': article.status === 'draft',
                                            'bg-gray-100 text-gray-800': article.status === 'archived'
                                          }"
                                          x-text="article.status"></span>
                                    <span class="text-sm text-gray-500" x-text="formatDate(article.created_at)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Message quand aucun résultat -->
                    <div x-show="filteredArticles().length === 0" class="px-6 py-4 text-center text-gray-500">
                        {{__('admin_dashboard.no_articles_found')}}
                    </div>
                </div>
            </div>

            <!-- Activité récente -->
            <div class="px-6 py-2 bg-gray-50 border-b">
                <select x-model="activityFilter" class="text-sm border-gray-300 rounded">
                    <option value="">{{__('admin_dashboard.all_activities')}}</option>
                    <option value="article">{{__('admin_dashboard.articles')}}</option>
                    <option value="user">{{__('admin_dashboard.users')}}</option>
                    <option value="system">{{__('admin_dashboard.system')}}</option>
                </select>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">{{__('admin_dashboard.recent_activity')}}</h2>
                        <a href="{{route('activity.index')}}" class="text-sm text-blue-600 hover:text-blue-800">{{__('admin_dashboard.view_all')}}</a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <!-- Exemple d'activités - À remplacer par vos données réelles -->
                        <template x-for="activity in recentActivity" :key="activity.id">
                            <div class="px-6 py-4">
                                <div class="flex items-start">
                                    <img class="h-10 w-10 rounded-full mr-3"
                                         :src="activity.causer.avatar"
                                         :alt="activity.causer.name">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between">
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm font-medium text-gray-900 truncate" x-text="activity.causer.name"></p>
                                                <span  class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium" :class="{
                                                    'bg-green-100 text-green-800': activity.event.includes('created'),
                                                    'bg-blue-100 text-blue-800': activity.event.includes('updated'),
                                                    'bg-yellow-100 text-yellow-800': activity.event.includes('deleted')
                                                    }">
                                                    <span class="flex-shrink-0" x-html="getActivityIcon(activity.subject_type)"></span>
                                                    <span x-text="activity.event"></span>
                                                </span>
                                            </div>
                                            <span class="text-xs text-gray-500 ml-2" x-text="formatTimeAgo(activity.created_at)"></span>
                                        </div>
                                        <p class="text-sm text-gray-500" x-text="activity.description"></p>

                                        <!-- Détails supplémentaires selon le type d'activité -->
                                        <template x-if="activity.type === 'article_created'">
                                            <a :href="`/admin/articles/${activity.item.id}/edit`"
                                               class="mt-1 text-sm text-blue-600 hover:text-blue-800 block truncate"
                                               x-text="`Article: ${activity.item.title}`"></a>
                                        </template>

                                        <template x-if="activity.type === 'user_updated'">
                                            <div class="mt-1 text-xs text-gray-500">
                                                <span x-text="`Champs modifiés: ${activity.changed_fields.join(', ')}`"></span>
                                            </div>
                                        </template>

                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- État vide -->
                        <div x-show="recentActivity.length === 0" class="px-6 py-4 text-center text-gray-500">
                            {{__('admin_dashboard.no_recent_activity')}}
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">{{__('admin_dashboard.statistics')}}</h2>
                    </div>
                    <div class="p-6">
                        <canvas id="statsChart" x-ref="chartCanvas" height="250"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
