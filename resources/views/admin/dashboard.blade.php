@extends('layouts.admin')

@section('page_title')
    {{ __('admin_dashboard.admin_dashboard') }}
@endsection

@section('admin-content')
    <div class="min-h-screen bg-gray-100">

        <!-- Main content -->
        <div class="pt-16">
            <!-- Content -->
            <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <div class="mb-6 flex items-start space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0">
                    <!-- Filtre par statut -->
                    <div class="relative w-full sm:w-72">
                        <select x-model="filters.status"
                            class="block w-full rounded-md border-1 border-supaGirlRose py-2 pl-3 pr-10 text-sm text-green-gs font-roboto-slab shadow-sm 
                            focus:border-supaGirlRose focus:outline-none focus:ring-supaGirlRose">
                            <option value="">{{ __('admin_dashboard.all_statuses') }}</option>
                            <option value='published'>{{ __('admin_dashboard.published') }}</option>
                            <option value='unpublished'>{{ __('admin_dashboard.draft') }}</option>
                            {{-- <option value="archived">{{__('admin_dashboard.archived')}}</option> --}}
                        </select>
                    </div>

                    <!-- Barre de recherche -->
                    <div class="relative w-full">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-gs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input x-model="filters.search" type="text"
                            class="block w-full rounded-md border-1 border-supaGirlRose py-2 pl-10 pr-3 shadow-sm text-green-gs
                            text-sm font-roboto-slab focus:border-supaGirlRose focus:outline-none focus:ring-supaGirlRose"
                            placeholder="{{ __('admin_dashboard.search_articles') }}">
                    </div>

                    <!-- Bouton reset -->
                    <button @click="resetFilters()"
                        class="cursor-pointer rounded-md bg-gray-100 px-4 py-2 text-green-gs font-roboto-slab transition hover:bg-fieldBg">
                        {{ __('admin_dashboard.reset') }}
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg bg-fieldBg p-6 shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-gs font-roboto-slab">{{ __('admin_dashboard.articles') }}</p>
                                <p class="text-2xl font-semibold text-textColor" x-text="stats.articles"></p>
                            </div>
                            <div class="rounded-full bg-supaGirlRose p-3 text-green-gs">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('articles.index') }}"
                                class="text-sm font-roboto-slab text-supaGirlRose hover:text-green-gs">{{ __('admin_dashboard.view_all') }}
                                →</a>
                        </div>
                    </div>
                    <div class="rounded-lg bg-fieldBg p-6 shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-gs font-roboto-slab">{{ __('admin_dashboard.users') }}</p>
                                <p class="text-2xl font-semibold text-textColor" x-text="stats.users"></p>
                            </div>
                            <div class="rounded-full bg-supaGirlRose p-3 text-green-gs">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 12q-1.65 0-2.825-1.175T8 8t1.175-2.825T12 4t2.825 1.175T16 8t-1.175 2.825T12 12m4 8v-6.4q.625.2 1.225.425t1.175.525q.75.375 1.175 1.088T20 17.2v.8q0 .825-.587 1.413T18 20zm-6-3.5v-3.35q.5-.075 1-.112T12 13t1 .038t1 .112v3.35zM4 18v-.8q0-.85.425-1.562T5.6 14.55q.575-.3 1.175-.525T8 13.6V20H6q-.825 0-1.412-.587T4 18" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('users.index') }}"
                                class="text-sm font-roboto-slab text-supaGirlRose hover:text-green-gs">{{ __('admin_dashboard.view_all') }}
                                →</a>
                        </div>
                    </div>
                    <div class="rounded-lg bg-fieldBg p-6 shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="flex items-center font-roboto-slab text-green-gs">
                                    {{ __('admin_dashboard.approved_escorts') }}
                                </p>
                                <p class="text-2xl font-semibold" x-text="stats.escorteApproved"></p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-supaGirlRose text-green-gs">
                                <i class="fas fa-user-check text-green-gs"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="#"
                                class="text-sm font-roboto-slab text-supaGirlRose hover:text-green-gs">{{ __('admin_dashboard.view_all') }}
                                →</a>
                        </div>
                    </div>
                    <!-- <div class="rounded-lg bg-fieldBg p-6 shadow">
                        <div x-data="{ isEditing: false, distanceMax: stats.distanceMax ?? 0 }">
                      
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="flex items-center font-roboto-slab text-green-gs">
                                        {{ __('admin_dashboard.escorts_around') }}
                                    </p>
                                    <template x-if="!isEditing">
                                        <p class="text-2xl font-semibold">
                                            <span x-text="stats.distanceMax + ' km'"></span>
                                        </p>
                                    </template>
                                    <template x-if="isEditing">
                                        <input type="number" name="distance_max"
                                            class="w-32 rounded border px-2 py-0 text-xl font-semibold"
                                            x-model="stats.distanceMax" />
                                    </template>
                                </div>
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-supaGirlRose text-green-gs">
                                    <i class="fas fa-user-check text-green-gs"></i>
                                </div>
                            </div>

                            
                            <form method="POST" action="{{ route('distance.update') }}">
                                @csrf
                                <input type="hidden" name="distance_max" x-model="stats.distanceMax">

                                <div class="mt-4">
                                    <button type="button" x-on:click="isEditing = !isEditing"
                                        x-text="isEditing ? '{{ __('admin_dashboard.cancel') }}' : '{{ __('admin_dashboard.edit') }} →'"
                                        class="text-sm font-roboto-slab text-supaGirlRose hover:text-green-gs">
                                    </button>

                                    <button x-show="isEditing" type="submit"
                                        class="rounded bg-green-gs px-2 py-1 text-sm text-white">
                                        {{ __('admin_dashboard.update') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div> -->
                </div>

                <!-- Derniers articles -->
                <div class="mb-8 overflow-hidden rounded-lg bg-fieldBg shadow">
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                        <div class="flex items-center gap-3">
                            <h2 @click="sort.field = 'title'; sort.direction = sort.direction === 'asc' ? 'desc' : 'asc'; sortedArticles()"
                                class="text-lg font-roboto-slab text-green-gs">{{ __('admin_dashboard.recent_articles') }}
                            </h2>
                            <span x-show="sort.field === 'title'" x-text="sort.direction === 'asc' ? '↑' : '↓'"
                                class="ml-1"></span>
                        </div>
                        <a href="{{ route('articles.create') }}" class="text-sm font-roboto-slab text-supaGirlRose hover:text-green-gs">+
                            {{ __('admin_dashboard.new_article') }}</a>
                    </div>
                    <div class="divide-y divide-fieldBg">
                        <template x-for="article in filteredArticles()" :key="article.id">
                            <div class="px-6 py-4 transition hover:bg-fieldBg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <a :href="`{{ route('articles.index') }}/${article.id}`"
                                            class="font-roboto-slab text-textColor hover:text-supaGirlRose"
                                            x-text="article.article.title['{{ app()->getLocale() }}']"></a>
                                        <p class="mt-1 text-sm text-gray-500 font-roboto-slab" x-text="article.article.excerpt['{{ app()->getLocale() }}'].length > 150 ? article.article.excerpt['{{ app()->getLocale() }}'].substring(0, 150) + '...' : article.article.excerpt['{{ app()->getLocale() }}']"></p>
                                        

                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="rounded-full px-2 py-1 text-xs font-roboto-slab"
                                            :class="{
                                                'bg-green-100 text-green-800': article.status === 'published',
                                                'bg-yellow-100 text-yellow-800': article.status === 'draft',
                                                'bg-gray-100 text-gray-800': article.status === 'archived'
                                            }"
                                            x-text="article.status"></span>
                                        <span class="text-sm text-gray-500 font-roboto-slab"
                                            x-text="formatDate(article.created_at)"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <!-- Message quand aucun résultat -->
                        <div x-show="filteredArticles().length === 0" class="px-6 py-4 text-center text-gray-500 font-roboto-slab">
                            {{ __('admin_dashboard.no_articles_found') }}
                        </div>
                    </div>
                </div>

                <!-- Activité récente -->
                <div class="mb-4 border-b-2 border-green-gs bg-supaGirlRose/80 px-6 py-2">
                    <select x-model="activityFilter" class="rounded border-green-gs text-sm text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs">
                        <option value="">{{ __('admin_dashboard.all_activities') }}</option>
                        <option value="article">{{ __('admin_dashboard.articles') }}</option>
                        <option value="user">{{ __('admin_dashboard.users') }}</option>
                        <option value="system">{{ __('admin_dashboard.system') }}</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div class="overflow-hidden rounded-lg bg-fieldBg shadow">
                        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                            <h2 class="text-lg font-roboto-slab text-green-gs">{{ __('admin_dashboard.recent_activity') }}
                            </h2>
                            <a href="{{ route('activity.index') }}"
                                class="text-sm font-roboto-slab text-textColorParagraph hover:text-green-gs">{{ __('admin_dashboard.view_all') }}</a>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <template x-for="activity in recentActivity" :key="activity.id">
                                <div class="px-6 py-4">
                                    <div class="flex items-start">
                                        <img class="mr-3 h-10 w-10 rounded-full bg-supaGirlRose text-green-gs font-roboto-slab" :src="activity.causer.avatar"
                                            :alt="activity.causer.name">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex justify-between">
                                                <div class="flex items-center gap-2">
                                                    <p class="truncate text-sm font-medium text-gray-900 font-roboto-slab"
                                                        x-text="activity.causer.name"></p>
                                                    <span
                                                        class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium"
                                                        :class="{
                                                            'bg-green-100 text-green-800': activity.event.includes(
                                                                'created'),
                                                            'bg-blue-100 text-blue-800': activity.event.includes(
                                                                'updated'),
                                                            'bg-yellow-100 text-yellow-800': activity.event.includes(
                                                                'deleted')
                                                        }">
                                                        <span class="flex-shrink-0"
                                                            x-html="getActivityIcon(activity.subject_type)"></span>
                                                        <span x-text="activity.event"></span>
                                                    </span>
                                                </div>
                                                <span class="ml-2 text-xs text-gray-500"
                                                    x-text="formatTimeAgo(activity.created_at)"></span>
                                            </div>
                                            <p class="pt-2 text-xs font-roboto-slab text-gray-500" x-text="activity.description"></p>

                                            <!-- Détails supplémentaires selon le type d'activité -->
                                            <template x-if="activity.type === 'article_created'">
                                                <a :href="`/admin/articles/${activity.item.id}/edit`"
                                                    class="mt-1 block truncate text-sm text-blue-600 hover:text-blue-800"
                                                    x-text="`Article: ${activity.item.title}`"></a>
                                            </template>

                                            <template x-if="activity.type === 'user_updated'">
                                                <div class="mt-1 text-xs text-gray-500">
                                                    <span
                                                        x-text="`Champs modifiés: ${activity.changed_fields.join(', ')}`"></span>
                                                </div>
                                            </template>

                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- État vide -->
                            <div x-show="recentActivity.length === 0" class="px-6 py-4 text-center text-gray-500 font-roboto-slab">
                                {{ __('admin_dashboard.no_recent_activity') }}
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="overflow-hidden rounded-lg bg-fieldBg shadow">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <h2 class="text-lg font-semibold text-green-gs font-roboto-slab">{{ __('admin_dashboard.statistics') }}</h2>
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
