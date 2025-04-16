@extends('layouts.admin')

@section('admin-content')
  <div x-data="articleManager()" x-init="init()" class="py-6 px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
          <h1 class="text-2xl font-bold text-gray-900">Gestion des Articles</h1>
          <a href="{{ route('articles.create') }}" class="btn-gs-gradient rounded-md">
              + Nouvel Article
          </a>
      </div>

      <!-- Filters -->
      <div class="mb-6 bg-white p-4 rounded-lg shadow">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <!-- Status Filter -->
              <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                  <select x-model="filters.status" class="w-full rounded-md border-gray-300 shadow-sm">
                      <option value="">Tous</option>
                      <option value="published">Publiés</option>
                      <option value="draft">Brouillons</option>
                  </select>
              </div>
              
              <!-- Category Filter -->
              <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                  <select x-model="filters.category" class="w-full rounded-md border-gray-300 shadow-sm">
                      <option value="">Toutes</option>
                      <template x-for="category in categories" :key="category.id">
                          <option :value="category.id" x-text="category.name"></option>
                      </template>
                  </select>
              </div>
              
              <!-- Date Range -->
              <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                  <div class="flex space-x-2">
                      <input type="date" x-model="filters.start_date" class="flex-1 rounded-md border-gray-300 shadow-sm">
                      <input type="date" x-model="filters.end_date" class="flex-1 rounded-md border-gray-300 shadow-sm">
                  </div>
              </div>
          </div>
      </div>

      <!-- Articles Table -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                  <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Titre
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Auteur
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Catégories
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Tags
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Date
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Statut
                      </th>
                      <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Actions
                      </th>
                  </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                  <template x-for="article in filteredArticles" :key="article.id">
                      <tr>
                          <td class="px-6 py-4 whitespace-nowrap">
                              <div class="font-medium text-gray-900" x-text="article.title"></div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                              <div class="flex items-center">
                                <img 
                                :src="article.user.avatar ? 'storage/avatars/' + article.user.avatar : '{{asset('icon-logo.png')}}'" 
                                class="h-8 w-8 rounded-full mr-2" 
                                />
                                  <span x-text="article.user.pseudo"></span>
                              </div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1" 
                                  x-text="article.category.name"></span>
                              {{-- <template x-for="category in article.category" :key="category.id">
                              </template> --}}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                              <template x-for="tag in article.tags" :key="tag.id">
                                  <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full mr-1 mb-1" 
                                        x-text="tag.name"></span>
                              </template>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" 
                              x-text="new Date(article.created_at).toLocaleDateString()"></td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <span class="mr-2 text-sm font-medium text-gray-700" x-text="article.is_published ? 'Publié' : 'Brouillon'"></span>
                              <button @click="toggleStatus(article)" type="button"
                                      :class="article.is_published ? 'bg-blue-600' : 'bg-gray-200'"
                                      class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                  <span :class="article.is_published ? 'translate-x-5' : 'translate-x-0'"
                                        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                              </button>
                          </div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex space-x-2 justify-end">
                                <!-- Bouton Éditer -->
                                <a :href="`{{route('articles.index')}}/${article.id}`" 
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Éditer
                                </a>
                                
                                <!-- Bouton Supprimer -->
                                <button @click="confirmDelete(article)"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 22H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </button>
                            </div>
                        </td>
                      </tr>
                  </template>
              </tbody>
          </table>
          
          <!-- Empty State -->
          <div x-show="filteredArticles.length === 0" class="p-8 text-center text-gray-500">
              Aucun article trouvé
          </div>
          
          <!-- Pagination -->
          <div class="px-6 py-4 border-t border-gray-200" x-show="articles.length > 0">
              <div class="flex justify-between items-center">
                  <div x-text="`Affichage de ${startItem} à ${endItem} sur ${totalItems} articles`"></div>
                  <div class="flex space-x-2">
                      <button @click="prevPage" :disabled="currentPage === 1" 
                              :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''"
                              class="px-3 py-1 border rounded-md">Précédent</button>
                      <button @click="nextPage" :disabled="currentPage === totalPages"
                              :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                              class="px-3 py-1 border rounded-md">Suivant</button>
                  </div>
              </div>
          </div>
      </div>

      <!-- Delete Confirmation Modal -->
      <div x-show="showDeleteModal" class="fixed z-50 inset-0 overflow-y-auto" x-cloak>
          <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
              <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                  <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
              </div>
              
              <div x-show="showDeleteModal" x-transition 
                  class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmer la suppression</h3>
                      <p class="text-gray-600">Êtes-vous sûr de vouloir supprimer définitivement "<span x-text="selectedArticle?.title"></span>" ?</p>
                  </div>
                  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                      <button @click="deleteArticle" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                          Supprimer
                      </button>
                      <button @click="showDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                          Annuler
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
                    if (this.filters.category && !(article.category.id == this.filters.category)) return false;
                    
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
                    detail: { type, message }
                });
                window.dispatchEvent(event);
            }
        }
    }
  </script>
  @endpush
@endsection