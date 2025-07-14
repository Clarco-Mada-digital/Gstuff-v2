@extends('layouts.admin')

@section('admin-content')
    <div x-data="articleManager()" x-init="init()" class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('article_management.article_management') }}</h1>
            <a href="{{ route('articles.create') }}" class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 
            rounded-md  shadow-md">
                + {{ __('article_management.new_article') }}
            </a>
        </div>

        <!-- Filters -->
        <div class="mb-6 rounded-lg bg-white p-4 shadow font-roboto-slab">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <!-- Status Filter -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('article_management.status') }}</label>
                    <select x-model="filters.status" class="w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">{{ __('article_management.all') }}</option>
                        <option value="published">{{ __('article_management.published') }}</option>
                        <option value="draft">{{ __('article_management.drafts') }}</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label
                        class="mb-1 block text-sm font-medium text-gray-700">{{ __('article_management.category') }}</label>
                    <select x-model="filters.category" class="w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">{{ __('article_management.all') }}</option>
                        <template x-for="category in categories" :key="category.id">
                            <option :value="category.id" x-text="category.name['{{ app()->getLocale() }}']"></option>
                        </template>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('article_management.date') }}</label>
                    <div class="flex space-x-2">
                        <input type="date" x-model="filters.start_date"
                            class="flex-1 rounded-md border-gray-300 shadow-sm">
                        <input type="date" x-model="filters.end_date"
                            class="flex-1 rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="overflow-hidden bg-white shadow sm:rounded-lg font-roboto-slab">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            {{ __('article_management.title') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            {{ __('article_management.author') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            {{ __('article_management.categories') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            {{ __('article_management.tags') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            {{ __('article_management.date') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            {{ __('article_management.status') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            {{ __('article_management.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <template x-for="article in filteredArticles" :key="article.id">
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900" x-text="article.title['{{ app()->getLocale() }}']"></div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    <img :src="article.user.avatar ? 'storage/avatars/' + article.user.avatar :
                                        '{{ asset('icon-logo.png') }}'"
                                        class="mr-2 h-8 w-8 rounded-full" />
                                    <span x-text="article.user.pseudo"></span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    class="mb-1 mr-1 inline-block rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800"
                                    x-text="article.category.name['{{ app()->getLocale() }}']"></span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <template x-for="tag in article.tags" :key="tag.id">
                                    <span
                                        class="mb-1 mr-1 inline-block rounded-full bg-purple-100 px-2 py-1 text-xs text-purple-800"
                                        x-text="tag.name"></span>
                                </template>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500"
                                x-text="new Date(article.created_at).toLocaleDateString()"></td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    <span class="mr-2 text-sm font-medium text-gray-700"
                                        x-text="article.is_published ? '{{ __('article_management.published') }}' : '{{ __('article_management.drafts') }}'"></span>
                                    <button @click="toggleStatus(article)" type="button"
                                        :class="article.is_published ? 'bg-blue-600' : 'bg-gray-200'"
                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <span :class="article.is_published ? 'translate-x-5' : 'translate-x-0'"
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <!-- Bouton Éditer -->
                                    <a :href="`{{ route('articles.index') }}/${article.id}`"
                                        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm transition-colors duration-150 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{ __('article_management.edit') }}
                                    </a>

                                    <!-- Bouton Supprimer -->
                                    <button @click="confirmDelete(article)"
                                        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 22H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        {{ __('article_management.delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <!-- Empty State -->
            <div x-show="filteredArticles.length === 0" class="p-8 text-center text-gray-500">
                {{ __('article_management.no_articles_found') }}
            </div>

            <!-- Pagination -->
            <div class="border-t border-gray-200 px-6 py-4" x-show="articles.length > 0">
                <div class="flex items-center justify-between">
                    <div
                        x-text="`{{ __('article_management.showing') }} ${startItem} {{ __('article_management.to') }} ${endItem} {{ __('article_management.of') }} ${totalItems} {{ __('article_management.articles') }}`">
                    </div>
                    <div class="flex space-x-2">
                        <button @click="prevPage" :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''"
                            class="rounded-md border px-3 py-1">{{ __('article_management.previous') }}</button>
                        <button @click="nextPage" :disabled="currentPage === totalPages"
                            :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                            class="rounded-md border px-3 py-1">{{ __('article_management.next') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
                <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 transition-opacity"
                    aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div x-show="showDeleteModal" x-transition
                    class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">
                            {{ __('article_management.confirm_deletion') }}</h3>
                        <p class="text-gray-600">
                            {{ __('article_management.confirm_deletion_message', ['title' => '<span x-text="selectedArticle?.title"></span>']) }}
                        </p>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button @click="deleteArticle" type="button"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('article_management.delete') }}
                        </button>
                        <button @click="showDeleteModal = false" type="button"
                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm">
                            {{ __('article_management.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            function articleManager() {
                return {
                    articles: @json($articles->items()),
                    categories: @json($categories),
                    tags: @json($tags),
                    currentPage: 1,
                    itemsPerPage: 10,
                    showDeleteModal: false,
                    selectedArticle: null,
                    filters: {
                        status: '',
                        category: '',
                        start_date: '',
                        end_date: ''
                    },

                    init() {
                        // Écouter les événements de mise à jour
                        window.addEventListener('article-updated', () => {
                            this.fetchArticles();
                        });
                    },

                    get filteredArticles() {
                        return this.articles.filter(article => {
                            // Filtre par statut
                            if (this.filters.status === 'published' && !article.is_published) return false;
                            if (this.filters.status === 'draft' && article.is_published) return false;

                            // Filtre par catégorie
                            if (this.filters.category && !(article.category.id == this.filters.category))
                                return false;

                            // Filtre par date
                            if (this.filters.start_date) {
                                const startDate = new Date(this.filters.start_date);
                                const articleDate = new Date(article.created_at);
                                if (articleDate < startDate) return false;
                            }

                            if (this.filters.end_date) {
                                const endDate = new Date(this.filters.end_date);
                                const articleDate = new Date(article.created_at);
                                if (articleDate > endDate) return false;
                            }

                            return true;
                        });
                    },

                    get totalItems() {
                        return this.filteredArticles.length;
                    },

                    get totalPages() {
                        return Math.ceil(this.totalItems / this.itemsPerPage);
                    },

                    get paginatedArticles() {
                        const start = (this.currentPage - 1) * this.itemsPerPage;
                        return this.filteredArticles.slice(start, start + this.itemsPerPage);
                    },

                    get startItem() {
                        return (this.currentPage - 1) * this.itemsPerPage + 1;
                    },

                    get endItem() {
                        return Math.min(this.currentPage * this.itemsPerPage, this.totalItems);
                    },

                    nextPage() {
                        if (this.currentPage < this.totalPages) this.currentPage++;
                    },

                    prevPage() {
                        if (this.currentPage > 1) this.currentPage--;
                    },

                    async fetchArticles() {
                        try {
                            const response = await fetch('/admin/articles/json');
                            const data = await response.json();
                            this.articles = data.articles;
                        } catch (error) {
                            console.error('Error fetching articles:', error);
                            this.showToast('error', 'Erreur lors du chargement des articles');
                        }
                    },

                    async toggleStatus(article) {
                        try {
                            const response = await fetch(`/admin/articles/${article.id}/status`, {
                                method: 'PATCH',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (response.ok) {
                                article.is_published = data.is_published;
                                this.showToast('success', data.message);
                            } else {
                                throw new Error(data.message || 'Erreur lors de la mise à jour');
                            }
                        } catch (error) {
                            this.showToast('error', error.message);
                        }
                    },

                    confirmDelete(article) {
                        this.selectedArticle = article;
                        this.showDeleteModal = true;
                    },

                    async deleteArticle() {
                        try {
                            const response = await fetch(`/admin/articles/${this.selectedArticle.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (response.ok) {
                                this.articles = this.articles.filter(a => a.id !== this.selectedArticle.id);
                                this.showToast('success', data.message);
                            } else {
                                throw new Error(data.message || 'Erreur lors de la suppression');
                            }
                        } catch (error) {
                            this.showToast('error', error.message);
                        } finally {
                            this.showDeleteModal = false;
                            this.selectedArticle = null;
                        }
                    },

                    showToast(type, message) {
                        const event = new CustomEvent('show-toast', {
                            detail: {
                                type,
                                message
                            }
                        });
                        window.dispatchEvent(event);
                    }
                }
            }
        </script>
    @endpush
@endsection
