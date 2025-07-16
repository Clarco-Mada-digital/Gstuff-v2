@extends('layouts.admin')

@section('admin-content')
    <div x-data="{ ...taxonomyManager(), showDeleteModal: false, itemToDelete: null, deleteType: null }" x-init="init()" class="container mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('taxonomy.taxonomy_management') }}</h1>
            <div class="flex space-x-3">
                <button @click="openModal('category')" class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 
            rounded-md  shadow-md">
                    {{ __('taxonomy.new_category') }}
                </button>
                <button @click="openModal('tag')" class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 
            rounded-md  shadow-md">
                    {{ __('taxonomy.new_tag') }}
                </button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="mb-6 border-b border-gray-200 font-roboto-slab">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'categories'"
                    :class="activeTab === 'categories' ? 'border-green-gs text-green-gs' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium font-roboto-slab">
                    {{ __('taxonomy.categories') }}
                </button>
                <button @click="activeTab = 'tags'"
                    :class="activeTab === 'tags' ? 'border-green-gs text-green-gs' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium font-roboto-slab">
                    {{ __('taxonomy.tags') }}
                </button>
            </nav>
        </div>

        <!-- Categories Table -->
        <div x-show="activeTab === 'categories'" x-transition class="overflow-hidden rounded-lg bg-white shadow font-roboto-slab">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 font-roboto-slab">
                            {{ __('taxonomy.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 font-roboto-slab">
                            {{ __('taxonomy.articles') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 font-roboto-slab">
                            {{ __('taxonomy.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <template x-for="category in categories" :key="category.id">
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900" x-text="category.name['{{ app()->getLocale() }}']"></div>
                                <div class="text-sm text-gray-500" x-text="category.slug"></div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800"
                                    x-text="category.articles_count"></span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <button @click="editItem('category', category)"
                                    class="mr-3 text-indigo-600 hover:text-indigo-900">{{ __('taxonomy.edit') }}</button>
                                <button @click="deleteItem('category', category.id)"
                                    class="text-red-600 hover:text-red-900">{{ __('taxonomy.delete') }}</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="border-t border-gray-200 px-6 py-4" x-show="categories.length === 0">
                <p class="text-center text-gray-500">{{ __('taxonomy.no_categories_found') }}</p>
            </div>
        </div>

        <!-- Tags Table -->
        <div x-show="activeTab === 'tags'" x-transition class="overflow-hidden rounded-lg bg-white shadow font-roboto-slab">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 font-roboto-slab">
                            {{ __('taxonomy.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            {{ __('taxonomy.articles') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            {{ __('taxonomy.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <template x-for="tag in tags" :key="tag.id">
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900" x-text="tag.name"></div>
                                <div class="text-sm text-gray-500" x-text="tag.slug"></div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800"
                                    x-text="tag.articles_count"></span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <button @click="editItem('tag', tag)"
                                    class="mr-3 text-indigo-600 hover:text-indigo-900">{{ __('taxonomy.edit') }}</button>
                                <button @click="deleteItem('tag', tag.id)"
                                    class="text-red-600 hover:text-red-900">{{ __('taxonomy.delete') }}</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="border-t border-gray-200 px-6 py-4" x-show="tags.length === 0">
                <p class="text-center text-gray-500">{{ __('taxonomy.no_tags_found') }}</p>
            </div>
        </div>

        <!-- Modale de confirmation de suppression -->
        <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
                <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 transition-opacity"
                    aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div x-show="showDeleteModal" x-transition
                    class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900">
                            {{ __('taxonomy.confirm_delete') }}
                        </h3>
                        <p class="text-gray-600">
                            {{ __('taxonomy.confirm_delete_message') }} <span
                                x-text="deleteType === 'category' ? '{{ __('taxonomy.category') }}' : '{{ __('taxonomy.tag') }}'"></span>
                            {{ __('taxonomy.irreversible_action') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" @click="confirmDelete"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('taxonomy.delete_button') }}
                        </button>
                        <button type="button" @click="showDeleteModal = false"
                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm">
                            {{ __('taxonomy.cancel_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Modal content -->
                <div x-show="isModalOpen" x-transition @click.away="closeModal"
                    class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
                    :class="{
                        'sm:max-w-md': modalType === 'tag',
                        'sm:max-w-lg': modalType === 'category'
                    }">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900" x-text="modalTitle"></h3>

                        <!-- Formulaire de création -->
                        <form x-show="!isEditing" @submit.prevent="submitForm">
                            <!-- Category specific fields -->
                            <div x-show="modalType === 'category'">
                                <input type="hidden" name="lang" x-model="formData.lang = '{{ app()->getLocale() }}'">
                                <div class="mb-4">
                                    <label for="category_name"
                                        class="block text-sm font-medium text-gray-700">{{ __('taxonomy.category_name') }}</label>
                                    <input type="text" id="category_name" x-model="formData.name" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="mb-4">
                                    <label for="category_description"
                                        class="block text-sm font-medium text-gray-700">{{ __('taxonomy.category_description') }}</label>
                                    <textarea id="category_description" x-model="formData.description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>

                            <!-- Tag specific fields -->
                            <div x-show="modalType === 'tag'">
                                <div class="mb-4">
                                    <label for="tag_name"
                                        class="block text-sm font-medium text-gray-700">{{ __('taxonomy.tag_name') }}</label>
                                    <input type="text" id="tag_name" x-model="formData.name" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </form>

                        <!-- Formulaire de mise à jour -->
                        <form x-show="isEditing" @submit.prevent="submitForm">
                            <!-- Category specific fields -->
                            <div x-show="modalType === 'category'">
                                <input type="hidden" name="lang" x-model="updateFormData.lang = '{{ app()->getLocale() }}'">
                                <input type="hidden" name="id" x-model="updateFormData.id">
                                <div class="mb-4">
                                    <label for="update_category_name"
                                        class="block text-sm font-medium text-gray-700">{{ __('taxonomy.category_name') }}</label>
                                    <input type="text" id="update_category_name" x-model="updateFormData.name" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="mb-4">
                                    <label for="update_category_description"
                                        class="block text-sm font-medium text-gray-700">{{ __('taxonomy.category_description') }}</label>
                                    <textarea id="update_category_description" x-model="updateFormData.description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>

                            <!-- Tag specific fields -->
                            <div x-show="modalType === 'tag'">
                                <input type="hidden" name="id" x-model="updateFormData.id">
                                <div class="mb-4">
                                    <label for="update_tag_name"
                                        class="block text-sm font-medium text-gray-700">{{ __('taxonomy.tag_name') }}</label>
                                    <input type="text" id="update_tag_name" x-model="updateFormData.name" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" @click="submitForm"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('taxonomy.save_button') }}
                        </button>
                        <button type="button" @click="closeModal"
                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm">
                            {{ __('taxonomy.cancel_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function taxonomyManager() {
                return {
                    activeTab: 'categories',
                    isModalOpen: false,
                    modalType: 'category', // 'category' or 'tag'
                    modalTitle: '',
                    isEditing: false,
                    currentId: null,
                    formData: {
                        name: '',
                        description: '',
                        is_active: true,
                        lang: ''
                    },
                    updateFormData: {
                        id: null,
                        name: '',
                        description: '',
                        is_active: true,
                        lang: ''
                    },
                    categories: @json($categories),
                    tags: @json($tags),

                    init() {
                        // Écouter les événements de succès
                        window.addEventListener('taxonomy-updated', () => {
                            this.fetchData();
                            this.closeModal();
                        });
                    },

                    openModal(type, item = null) {
                        this.modalType = type;
                        this.isEditing = item !== null;
                        this.currentId = item?.id || null;

                        if (this.isEditing) {
                            this.modalTitle =
                                `${this.modalType === 'category' ? '{{ __('taxonomy.edit_category') }}' : '{{ __('taxonomy.edit_tag') }}'}`;
                            
                            if (type === 'category') {
                                this.updateFormData = {
                                    id: item.id,
                                    name: item.name ? (typeof item.name === 'object' ? item.name['{{ app()->getLocale() }}'] : item.name) : '',
                                    description: item.description ? (typeof item.description === 'object' ? item.description['{{ app()->getLocale() }}'] || '' : item.description) : '',
                                    is_active: item.is_active || true
                                };
                            } else {
                                // Pour les tags, on suppose que le nom est une chaîne simple
                                this.updateFormData = {
                                    id: item.id,
                                    name: item.name || '',
                                    is_active: item.is_active || true
                                };
                            }
                        } else {
                            this.modalTitle =
                                `${this.modalType === 'category' ? '{{ __('taxonomy.create_category') }}' : '{{ __('taxonomy.create_tag') }}'}`;
                            this.formData = {
                                name: '',
                                description: type === 'category' ? '' : undefined,
                                is_active: true
                            };
                        }

                        this.isModalOpen = true;
                    },

                    closeModal() {
                        this.isModalOpen = false;
                        this.resetForm();
                    },

                    resetForm() {
                        this.formData = {
                            name: '',
                            description: '',
                            is_active: true
                        };
                        this.currentId = null;
                        this.isEditing = false;
                    },



                    async submitForm() {
                        const url = this.modalType === 'category' ?
                            (this.isEditing ?
                                `/admin/categories/${this.currentId}` :
                                '/admin/categories') :
                            (this.isEditing ?
                                `/admin/tags/${this.currentId}` :
                                '/admin/tags');

                        const method = this.isEditing ? 'PUT' : 'POST';
                       



                        try {
                            const response = await fetch(url, {
                                method: method,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(this.isEditing ? this.updateFormData : this.formData)
                            });

                            const data = await response.json();

                            console.log("data all",data);
                            this.fetchData();

                         

                            if (response.ok) {
                                window.dispatchEvent(new CustomEvent('taxonomy-updated'));
                                this.showToast('success', data.message || 'Opération réussie');
                            } else {
                                throw new Error(data.message || 'Erreur lors de la requête');
                            }
                        } catch (error) {
                            this.showToast('error', error.message);
                            console.error('Error:', error);
                        }
                    },





                    async deleteItem(type, id) {
                        if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) return;

                        const url = type === 'category' ?
                            `/admin/categories/${id}` :
                            `/admin/tags/${id}`;

                        try {
                            const response = await fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (response.ok) {
                                window.dispatchEvent(new CustomEvent('taxonomy-updated'));
                                this.showToast('success', data.message || 'Élément supprimé');
                            } else {
                                throw new Error(data.message || 'Erreur lors de la suppression');
                            }
                        } catch (error) {
                            this.showToast('error', error.message);
                            console.error('Error:', error);
                        }
                    },

                    async fetchData() {

                     
                        try {
                            const [categoriesRes, tagsRes] = await Promise.all([
                                fetch('/admin/fetchCategories'),
                                fetch('/admin/fetchTags')
                            ]);

                            const [categoriesData, tagsData] = await Promise.all([
                                categoriesRes.json(),
                                tagsRes.json()
                            ]);

                          
        

                            this.categories = categoriesData.categories;
                            this.tags = tagsData.tags;
                        } catch (error) {
                            console.error('Error fetching data:', error);
                            this.showToast('error', 'Erreur lors du chargement des données');
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
                    },

                    editItem(type, item) {

                   
                        this.openModal(type, item);
                    },

                    deleteItem(type, id) {
                        this.deleteType = type;
                        this.itemToDelete = id;
                        this.showDeleteModal = true;
                    },

                    async confirmDelete() {
                        this.showDeleteModal = false;
                        const type = this.deleteType;
                        const id = this.itemToDelete;

                        try {
                            const url = type === 'category' ?
                                `/admin/categories/${id}` :
                                `/admin/tags/${id}`;

                            const response = await fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (response.ok) {
                                window.dispatchEvent(new CustomEvent('taxonomy-updated'));
                                this.showToast('success', data.message || 'Élément supprimé avec succès');
                            } else {
                                throw new Error(data.message || 'Erreur lors de la suppression');
                            }
                        } catch (error) {
                            this.showToast('error', error.message);
                            console.error('Error:', error);
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
