@extends('layouts.admin')

@section('pageTitle')
    {{ __('article_edit.page_title') }}
@endsection

@section('admin-content')
    <div x-data="articleForm()" x-init="init()" class="font-roboto-slab mx-auto max-w-4xl px-4 py-8" x-cloak>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-green-gs font-roboto-slab text-2xl font-bold">{{ __('article_edit.edit_article') }}
                ({{ $article->title }})</h1>
            <a href="{{ route('articles.admin') }}"
                class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('article_edit.back') }}
            </a>
        </div>

        <form action="{{ route('articles.update', $article->id) }}" method="POST" class="rounded-lg bg-white p-6 shadow-md">
            @csrf

            <!-- Titre -->
            <div class="mb-6">
                <label for="title"
                    class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('article_edit.title') }}*</label>
                <input type="text" name="title" id="title" x-model="title" x-on:focusout="generateSlug()"
                    value='{{ $article->title }}'
                    class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border border-gray-300 px-4 py-2 transition focus:ring-2"
                    required>
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug"
                    class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('article_edit.slug') }}*</label>
                <input type="text" name="slug" id="slug" x-model="slug" value="{{ $article->slug }}"
                    class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border border-gray-300 px-4 py-2 transition focus:ring-2"
                    required>
                <p class="mt-1 text-sm text-gray-500">Version URL-friendly du titre</p>
                @error('slug')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }}</p>
                @enderror
            </div>

            <!-- excerpt -->
            <div class="mb-6">
                <label for="excerpt"
                    class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('article_edit.excerpt') }}*</label>
                <textarea name="excerpt" id="excerpt"
                    class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border border-gray-300 px-4 py-2 transition focus:ring-2"
                    required>{!! $article->excerpt !!}</textarea>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }}</p>
                @enderror
            </div>

            <!-- Contenu -->
            <div x-data="app()" x-init="init($refs.wysiwyg)" class="mb-6">
                <label for="content"
                    class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('article_edit.content') }}*</label>
                <textarea x-model="content" name="content" id="content" rows="10" class="hidden" required></textarea>
                <div class="mx-auto w-full max-w-6xl rounded-xl bg-white text-black">
                    <div class="overflow-hidden rounded-md border border-gray-200">
                        <div class="flex w-full border-b border-gray-200 text-xl text-gray-600">
                            <!-- Boutons de formatage -->
                        </div>
                        <div class="w-full">
                            <iframe x-ref="wysiwyg" class="h-96 w-full overflow-y-auto"></iframe>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catégorie -->
            <div class="mb-6">
                <label for="article_category_id"
                    class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('article_edit.category') }}*</label>
                <select name="article_category_id" id="article_category_id"
                    class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border border-gray-300 px-4 py-2 transition focus:ring-2"
                    required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($article->category?->id == $category->id) selected @endif>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                        {{ $message }}</p>
                @enderror
            </div>

            <!-- Tags -->
            <div class="mb-6">
                <label
                    class="text-green-gs font-roboto-slab mb-2 block text-sm font-medium">{{ __('article_edit.tags') }}</label>

                <!-- Champ de recherche et sélection -->
                <div class="relative mb-3">
                    <input type="text" x-model="tagSearch" x-on:input.debounce.300ms="searchTags()"
                        x-on:keydown.enter.prevent="handleTagEnter" x-ref="tagInput"
                        class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border border-gray-300 px-4 py-2 transition focus:ring-2"
                        placeholder="Rechercher ou ajouter des tags">

                    <!-- Suggestions de tags -->
                    <div x-show="tagSuggestions.length > 0 && tagSearch.length > 0" x-transition
                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md border border-gray-200 bg-white shadow-lg">
                        <template x-for="tag in tagSuggestions" :key="tag.id">
                            <div x-on:click="addTag(tag)"
                                class="hover:bg-green-gs/50 flex cursor-pointer items-center justify-between px-4 py-2">
                                <span x-text="tag.name"></span>
                                <span class="text-xs text-gray-500">Existe</span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Option pour créer un nouveau tag -->
                <div x-show="showCreateTagOption" x-transition class="mb-3">
                    <div class="flex items-center justify-between rounded-md bg-gray-50 p-3">
                        <span class="text-sm">
                            Tag "<span x-text="tagSearch" class="font-medium"></span>" n'existe pas.
                        </span>
                        <button type="button" x-on:click="openCreateTagModal()"
                            class="bg-green-gs hover:bg-green-gs/80 rounded px-3 py-1 text-sm text-white">
                            {{ __('article_edit.create_tag') }}
                        </button>
                    </div>
                </div>

                <!-- Tags sélectionnés -->
                <div class="flex flex-wrap gap-2">
                    <template x-for="tag in selectedTags" :key="tag.id">
                        <div
                            class="bg-supaGirlRosePastel text-green-gs font-roboto-slab inline-flex items-center rounded-full px-3 py-1 text-sm">
                            <span x-text="tag.name"></span>
                            <button type="button" x-on:click="removeTag(tag.id)"
                                class="text-green-gs hover:text-green-gs ml-2">
                                &times;
                            </button>
                            <input type="hidden" name="tags[]" x-bind:value="tag.id">
                        </div>
                    </template>
                </div>
            </div>

            <!-- Publication -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" value="1" x-model="isPublished"
                        checked="{{ $article->is_published }}"
                        class="text-green-gs focus:ring-green-gs h-4 w-4 rounded border-gray-300">
                    <label for="is_published"
                        class="text-green-gs font-roboto-slab ml-2 block text-sm">{{ __('article_edit.publish_article') }}</label>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                    {{ __('article_edit.modify_article') }}
                </button>
            </div>
        </form>

        <!-- Modale de création de tag -->
        <div x-show="showTagModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div x-on:click.away="closeCreateTagModal" class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                <h3 class="mb-4 text-lg font-medium text-gray-900">{{ __('article_edit.create_tag') }}</h3>

                <div class="mb-4">
                    <label for="newTagName"
                        class="mb-1 block text-sm font-medium text-gray-700">{{ __('article_edit.new_tag_name') }}*</label>
                    <input type="text" id="newTagName" x-model="tagSearch"
                        class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border border-gray-300 px-4 py-2 transition focus:ring-2"
                        required>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" x-on:click="closeCreateTagModal"
                        class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">
                        {{ __('article_edit.cancel') }}
                    </button>
                    <button type="button" x-on:click="createNewTag"
                        class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                        {{ __('article_edit.create_tag_button') }}
                    </button>
                </div>
            </div>
        </div>
    </div>


@section('specialScripts')
    <script>
        function articleForm() {
            return {
                title: '',
                slug: '',
                isPublished: {{ $article->is_published }},
                publishedAt: '',

                // Gestion des tags
                tagSearch: '',
                tagSuggestions: [],
                selectedTags: [],
                showCreateTagOption: false,
                showTagModal: false,
                availableTags: '',

                init() {
                    // Initialisation des valeurs existantes (en cas de validation échouée)
                    if (document.getElementById('title').value) {
                        this.title = document.getElementById('title').value;
                    }
                    if (document.getElementById('slug').value) {
                        this.slug = document.getElementById('slug').value;
                    }

                    this.publishedAt = this.getLocalDateTime();
                    this.availableTags = @json($tags);

                    this.selectedTags = @json($article->tags->toArray());

                    // Initialisation des tags sélectionnés
                    const existingTags = document.querySelectorAll('input[name="tags[]"]');
                    existingTags.forEach(input => {
                        const tagId = parseInt(input.value);
                        const tag = this.availableTags.find(t => t.id === tagId);
                        if (tag) this.selectedTags.push(tag);
                    });

                },

                generateSlug() {
                    if (!this.slug || this.slug === this.slugFromTitle(this.title)) {
                        this.slug = this.slugFromTitle(this.title);
                    }
                },

                slugFromTitle(title) {
                    return title
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s]+/g, '-')
                        .replace(/[-]+/g, '-')
                        .substring(0, 60);
                },

                getLocalDateTime() {
                    const now = new Date();
                    const timezoneOffset = now.getTimezoneOffset() * 60000;
                    return new Date(now - timezoneOffset).toISOString().slice(0, 16);
                },

                // Fonctions pour la gestion des tags
                searchTags() {
                    if (this.tagSearch.length < 2) {
                        this.tagSuggestions = [];
                        this.showCreateTagOption = false;
                        return;
                    }

                    const searchTerm = this.removeAccents(this.tagSearch.toLowerCase());

                    this.tagSuggestions = this.availableTags.filter(tag => {
                        // Vérifie si le tag est déjà sélectionné
                        if (this.selectedTags.some(t => t.id === tag.id)) return false;

                        // Normalise le nom du tag pour la comparaison
                        const tagName = this.removeAccents(tag.name.toLowerCase());

                        // Recherche approximative
                        return this.fuzzyMatch(tagName, searchTerm);
                    });

                    // Trier par pertinence (meilleures correspondances en premier)
                    this.tagSuggestions.sort((a, b) => {
                        const aName = this.removeAccents(a.name.toLowerCase());
                        const bName = this.removeAccents(b.name.toLowerCase());

                        const aScore = this.similarity(aName, searchTerm);
                        const bScore = this.similarity(bName, searchTerm);

                        return bScore - aScore;
                    });

                    // Ne montrer que les meilleurs résultats
                    this.tagSuggestions = this.tagSuggestions.slice(0, 5);

                    // Vérifier si une correspondance exacte existe déjà
                    const exactMatch = this.availableTags.some(tag => {
                        const tagName = this.removeAccents(tag.name.toLowerCase());
                        return tagName === searchTerm;
                    });

                    this.showCreateTagOption = !exactMatch && this.tagSearch.length > 0;
                },

                // Fonction pour enlever les accents
                removeAccents(str) {
                    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                },

                // Recherche floue simple
                fuzzyMatch(text, search) {
                    text = this.removeAccents(text);
                    search = this.removeAccents(search);

                    // Si la recherche est incluse dans le texte
                    if (text.includes(search)) return true;

                    // Si la distance de Levenshtein est petite
                    if (this.levenshteinDistance(text, search) <= 2) return true;

                    return false;
                },

                // Calcul de similarité (entre 0 et 1)
                similarity(s1, s2) {
                    const longer = s1.length > s2.length ? s1 : s2;
                    const shorter = s1.length > s2.length ? s2 : s1;

                    // Si la chaîne plus longue contient la plus courte
                    if (longer.includes(shorter)) {
                        return shorter.length / longer.length;
                    }

                    // Sinon, utiliser la distance de Levenshtein
                    const distance = this.levenshteinDistance(longer, shorter);
                    return 1 - (distance / Math.max(longer.length, shorter.length));
                },

                // Distance de Levenshtein (pour la similarité)
                levenshteinDistance(s, t) {
                    if (!s.length) return t.length;
                    if (!t.length) return s.length;

                    const arr = [];
                    for (let i = 0; i <= t.length; i++) {
                        arr[i] = [i];
                        for (let j = 1; j <= s.length; j++) {
                            arr[i][j] = i === 0 ?
                                j :
                                Math.min(
                                    arr[i - 1][j] + 1,
                                    arr[i][j - 1] + 1,
                                    arr[i - 1][j - 1] + (s[j - 1] === t[i - 1] ? 0 : 1)
                                );
                        }
                    }

                    return arr[t.length][s.length];
                },

                // Validation en appuent avec touche Entrer
                handleTagEnter() {
                    if (this.tagSuggestions.length > 0) {
                        this.addTag(this.tagSuggestions[0]);
                    } else if (this.showCreateTagOption) {
                        this.openCreateTagModal();
                    }
                },

                // Ajout de tags au liste
                addTag(tag) {
                    if (!this.selectedTags.some(t => t.id === tag.id)) {
                        this.selectedTags.push(tag);
                    }
                    this.tagSearch = '';
                    this.tagSuggestions = [];
                    this.showCreateTagOption = false;
                    this.$refs.tagInput.focus();
                },

                removeTag(tagId) {
                    this.selectedTags = this.selectedTags.filter(tag => tag.id !== tagId);
                },

                openCreateTagModal() {
                    this.showTagModal = true;
                },

                closeCreateTagModal() {
                    this.showTagModal = false;
                },

                async createNewTag() {
                    if (!this.tagSearch.trim()) return;

                    try {
                        const response = await fetch('{{ route('tags.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                name: this.tagSearch.trim()
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422 && data.errors) {
                                throw new Error(data.message || 'Validation error');
                            }
                            throw new Error(data.message || 'Erreur lors de la création');
                        }

                        // const newTag = await response.json();

                        // Ajouter le nouveau tag aux tags disponibles
                        this.availableTags.push(data.tag);

                        // Sélectionner le nouveau tag
                        this.addTag(data.tag);

                        // Fermer la modale
                        this.closeCreateTagModal();

                    } catch (error) {
                        console.error('Erreur:', error);
                        alert('Erreur: ' + error.message);
                    }
                }
            }
        };

        function app() {
            return {
                wysiwyg: null,
                content: '',
                init: function(el) {
                    // Get el
                    this.wysiwyg = el;
                    // Add CSS
                    this.wysiwyg.contentDocument.querySelector('head').innerHTML += `<style>
                *, ::after, ::before {box-sizing: border-box;}
                :root {tab-size: 4;}
                html {line-height: 1.15;text-size-adjust: 100%;}
                body {margin: 0px; padding: 1rem 0.5rem;}                
                </style>`;
                    this.wysiwyg.contentDocument.body.innerHTML = `{!! $article->content !!}`;
                    this.content = this.wysiwyg.contentDocument.body.innerHTML; // Set initial content
                    // Make editable
                    this.wysiwyg.contentDocument.designMode = "on";

                    // Add event listener for input changes
                    this.wysiwyg.contentDocument.body.addEventListener('input', () => {
                        this.content = this.wysiwyg.contentDocument.body
                            .innerHTML; // Update content with the current HTML
                    });
                },
                format: function(cmd, param) {
                    this.wysiwyg.contentDocument.execCommand(cmd, !1, param || null);
                },
            }
        }
    </script>
@endsection

@endsection
