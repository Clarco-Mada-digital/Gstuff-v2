@extends('layouts.admin')

@section('admin-content')
    <div x-data="{...taxonomyManager(), showDeleteModal: false, itemToDelete: null, deleteType: null}" x-init="init()" class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ __('taxonomy.taxonomy_management') }}</h1>
            <div class="flex space-x-3">
                <button @click="openModal('category')" class="btn-gs-gradient rounded-md">
                    {{ __('taxonomy.new_category') }}
                </button>
                <button @click="openModal('tag')" class="btn-gs-gradient rounded-md">
                    {{ __('taxonomy.new_tag') }}
                </button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'categories'"
                        :class="activeTab === 'categories' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    {{ __('taxonomy.categories') }}
                </button>
                <button @click="activeTab = 'tags'"
                        :class="activeTab === 'tags' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    {{ __('taxonomy.tags') }}
                </button>
            </nav>
        </div>

        <!-- Categories Table -->
        <div x-show="activeTab === 'categories'" x-transition class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('taxonomy.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('taxonomy.articles') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('taxonomy.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="category in categories" :key="category.id">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900" x-text="category.name"></div>
                                <div class="text-sm text-gray-500" x-text="category.slug"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"
                                    x-text="category.articles_count"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button @click="editItem('category', category)" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('taxonomy.edit') }}</button>
                                <button @click="deleteItem('category', category.id)" class="text-red-600 hover:text-red-900">{{ __('taxonomy.delete') }}</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-200" x-show="categories.length === 0">
                <p class="text-gray-500 text-center">{{ __('taxonomy.no_categories_found') }}</p>
            </div>
        </div>

        <!-- Tags Table -->
        <div x-show="activeTab === 'tags'" x-transition class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('taxonomy.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('taxonomy.articles') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('taxonomy.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="tag in tags" :key="tag.id">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900" x-text="tag.name"></div>
                                <div class="text-sm text-gray-500" x-text="tag.slug"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"
                                    x-text="tag.articles_count"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button @click="editItem('tag', tag)" class="text-indigo-600 hover:text-indigo-900 mr-3">{{ __('taxonomy.edit') }}</button>
                                <button @click="deleteItem('tag', tag.id)" class="text-red-600 hover:text-red-900">{{ __('taxonomy.delete') }}</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-200" x-show="tags.length === 0">
                <p class="text-gray-500 text-center">{{ __('taxonomy.no_tags_found') }}</p>
            </div>
        </div>

         <!-- Modale de confirmation de suppression -->
        <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div x-show="showDeleteModal" x-transition
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            {{ __('taxonomy.confirm_delete') }}
                        </h3>
                        <p class="text-gray-600">
                            {{ __('taxonomy.confirm_delete_message') }} <span x-text="deleteType === 'category' ? '{{ __('taxonomy.category') }}' : '{{ __('taxonomy.tag') }}'"></span> {{ __('taxonomy.irreversible_action') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('taxonomy.delete_button') }}
                        </button>
                        <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('taxonomy.cancel_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Modal content -->
                <div x-show="isModalOpen" x-transition
                    @click.away="closeModal"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    :class="{
                        'sm:max-w-md': modalType === 'tag',
                        'sm:max-w-lg': modalType === 'category'
                    }">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" x-text="modalTitle"></h3>

                        <form @submit.prevent="submitForm">
                            <!-- Category specific fields -->
                            <div x-show="modalType === 'category'">
                                <div class="mb-4">
                                    <label for="category_name" class="block text-sm font-medium text-gray-700">{{ __('taxonomy.category_name') }}</label>
                                    <input type="text" id="category_name" x-model="formData.name" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div class="mb-4">
                                    <label for="category_description" class="block text-sm font-medium text-gray-700">{{ __('taxonomy.category_description') }}</label>
                                    <textarea id="category_description" x-model="formData.description" rows="3"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>

                            <!-- Tag specific fields -->
                            <div x-show="modalType === 'tag'">
                                <div class="mb-4">
                                    <label for="tag_name" class="block text-sm font-medium text-gray-700">{{ __('taxonomy.category_name') }}</label>
                                    <input type="text" id="tag_name" x-model="formData.name" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="submitForm" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('taxonomy.save_button') }}
                        </button>
                        <button type="button" @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
                is_active: true
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
                    this.modalTitle = `${this.modalType === 'category' ? '{{ __('taxonomy.edit_category') }}' : '{{ __('taxonomy.edit_tag') }}'}`;
                    this.formData = {
                        name: item.name,
                        description: item.description || '',
                        is_active: item.is_active || true
                    };
                } else {
                    this.modalTitle = `${this.modalType === 'category' ? '{{ __('taxonomy.create_category') }}' : '{{ __('taxonomy.create_tag') }}'}`;
                    this.formData = {
                        name: '',
                        description: '',
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
                const url = this.modalType === 'category'
                    ? (this.isEditing
                        ? `/admin/categories/${this.currentId}`
                        : '/admin/categories')
                    : (this.isEditing
                        ? `/admin/tags/${this.currentId}`
                        : '/admin/tags');

                const method = this.isEditing ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const data = await response.json();

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

                const url = type === 'category'
                    ? `/admin/categories/${id}`
                    : `/admin/tags/${id}`;

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
                        fetch('/admin/categories?json=1'),
                        fetch('/admin/tags?json=1')
                    ]);

                    const [categoriesData, tagsData] = await Promise.all([
                        categoriesRes.json(),
                        tagsRes.json()
                    ]);

                    this.categories = categoriesData;
                    this.tags = tagsData;
                } catch (error) {
                    console.error('Error fetching data:', error);
                    this.showToast('error', 'Erreur lors du chargement des données');
                }
            },

            showToast(type, message) {
                const event = new CustomEvent('show-toast', {
                    detail: { type, message }
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
                    const url = type === 'category'
                        ? `/admin/categories/${id}`
                        : `/admin/tags/${id}`;

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
