@extends('layouts.admin')

@section('pageTitle')
    {{ __('create_article.new_glossary') }}
@endsection

@section('admin-content')
    <div x-data="articleForm()" x-init="init()" class="mx-auto max-w-4xl px-4 py-8 font-roboto-slab" x-cloak>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('create_article.create_new_article') }}</h1>
            <a href="{{ route('articles.admin') }}" class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 
            rounded-md  shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('create_article.back') }}
            </a>
        </div>

        <form action="{{ route('articles.store') }}" method="POST" class="rounded-lg bg-white p-6 shadow-md">
            @csrf

            <input type="hidden" name="article_user_id" value="{{ auth()->user()->id }}">

            <!-- Titre -->
            <div class="mb-6">
                <label for="title"
                    class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_article.title') }}*</label>
                <input type="text" name="title" id="title" x-model="title" x-on:focusout="generateSlug()"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 transition focus:border-green-gs focus:ring-2 focus:ring-green-gs"
                    required>
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                            class="font-medium">{{ __('create_article.oops') }}!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug"
                    class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_article.slug') }}*</label>
                <input type="text" name="slug" id="slug" x-model="slug"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 transition focus:border-green-gs focus:ring-2 focus:ring-green-gs"
                    required>
                <p class="mt-1 text-sm text-gray-500">{{ __('create_article.url_friendly_version') }}</p>
                @error('slug')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                            class="font-medium">{{ __('create_article.oops') }}!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="mb-6">
                <label for="excerpt"
                    class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_article.excerpt') }}*</label>
                <textarea name="excerpt" id="excerpt"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 transition focus:border-green-gs focus:ring-2 focus:ring-green-gs"
                    required></textarea>
                @error('excerpt')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                            class="font-medium">{{ __('create_article.oops') }}!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Contenu -->
            <div x-data="app()" x-init="init($refs.wysiwyg)" class="mb-6">
                <label for="content"
                    class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_article.content') }}*</label>
                <textarea x-model="content" name="content" id="content" rows="10" class="hidden" required></textarea>
                <div class="mx-auto w-full max-w-6xl rounded-xl bg-white text-black">
                    <div class="overflow-hidden rounded-md border border-gray-200">
                        <div class="flex w-full border-b border-gray-200 text-xl text-green-gs font-roboto-slab">
                            <button type="button"
                                class="h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('bold')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M8.8 19q-.825 0-1.412-.587T6.8 17V7q0-.825.588-1.412T8.8 4h3.525q1.625 0 3 1T16.7 8.775q0 1.275-.575 1.963t-1.075.987q.625.275 1.388 1.025T17.2 15q0 2.225-1.625 3.113t-3.05.887zm1.025-2.8h2.6q1.2 0 1.463-.612t.262-.888t-.262-.887t-1.538-.613H9.825zm0-5.7h2.325q.825 0 1.2-.425t.375-.95q0-.6-.425-.975t-1.1-.375H9.825z">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('italic')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5.789 18.25v-1.115h3.634l3.48-10.27H9.27V5.75h8.308v1.116h-3.52l-3.48 10.269h3.52v1.115z">
                                </svg>
                            </button>
                            <button type="button"
                                class="mr-1 h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('underline')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M8 3v9a4 4 0 0 0 8 0V3h2v9a6 6 0 0 1-12 0V3zM4 20h16v2H4z">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-l border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('formatBlock','P')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M10 20q-.425 0-.712-.288T9 19v-5q-2.075 0-3.537-1.463T4 9t1.463-3.537T9 4h8q.425 0 .713.288T18 5t-.288.713T17 6h-1v13q0 .425-.288.713T15 20t-.712-.288T14 19V6h-3v13q0 .425-.288.713T10 20z">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('formatBlock','H1')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="-5 -7 24 24">
                                    <path fill="currentColor"
                                        d="M2 4h4V1a1 1 0 1 1 2 0v8a1 1 0 1 1-2 0V6H2v3a1 1 0 1 1-2 0V1a1 1 0 1 1 2 0zm9.52.779H10V3h3.36v7h-1.84z">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('formatBlock','H2')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="-4.5 -7 24 24">
                                    <path fill="currentColor"
                                        d="M2 4h4V1a1 1 0 1 1 2 0v8a1 1 0 1 1-2 0V6H2v3a1 1 0 1 1-2 0V1a1 1 0 1 1 2 0zm12.88 4.352V10H10V8.986l.1-.246l1.785-1.913c.43-.435.793-.77.923-1.011c.124-.23.182-.427.182-.587c0-.14-.04-.242-.127-.327a.47.47 0 0 0-.351-.127a.44.44 0 0 0-.355.158c-.105.117-.165.288-.173.525l-.012.338h-1.824l.016-.366c.034-.735.272-1.33.718-1.77S11.902 3 12.585 3q.637 0 1.14.275a2.1 2.1 0 0 1 .806.8q.299.516.3 1.063c0 .416-.23.849-.456 1.307c-.222.45-.534.876-1.064 1.555l-.116.123l-.254.229z">
                                </svg>
                            </button>
                            <button type="button"
                                class="mr-1 h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('formatBlock','H3')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="-4.5 -6.5 24 24">
                                    <path fill="currentColor"
                                        d="M2 4h4V1a1 1 0 1 1 2 0v8a1 1 0 1 1-2 0V6H2v3a1 1 0 1 1-2 0V1a1 1 0 1 1 2 0zm12.453 2.513l.043.055c.254.334.38.728.38 1.172c0 .637-.239 1.187-.707 1.628c-.466.439-1.06.658-1.763.658c-.671 0-1.235-.209-1.671-.627s-.673-.983-.713-1.676L10 7.353h1.803l.047.295c.038.238.112.397.215.49c.1.091.23.137.402.137a.57.57 0 0 0 .422-.159a.5.5 0 0 0 .158-.38c0-.163-.067-.295-.224-.419c-.17-.134-.438-.21-.815-.215l-.345-.004v-1.17l.345-.004c.377-.004.646-.08.815-.215c.157-.124.224-.255.224-.418a.5.5 0 0 0-.158-.381a.57.57 0 0 0-.422-.159a.57.57 0 0 0-.402.138c-.103.092-.177.251-.215.489l-.047.295H10l.022-.37c.04-.693.277-1.258.713-1.675c.436-.419 1-.628 1.67-.628c.704 0 1.298.22 1.764.658c.468.441.708.991.708 1.629a1.9 1.9 0 0 1-.424 1.226">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-l border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('insertUnorderedList')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M9 19v-2h12v2zm0-6v-2h12v2zm0-6V5h12v2zM5 20q-.825 0-1.412-.587T3 18t.588-1.412T5 16t1.413.588T7 18t-.587 1.413T5 20m0-6q-.825 0-1.412-.587T3 12t.588-1.412T5 10t1.413.588T7 12t-.587 1.413T5 14m0-6q-.825 0-1.412-.587T3 6t.588-1.412T5 4t1.413.588T7 6t-.587 1.413T5 8">
                                </svg>
                            </button>
                            <button type="button"
                                class="mr-1 h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('insertOrderedList')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 22v-1.5h2.5v-.75H4v-1.5h1.5v-.75H3V16h3q.425 0 .713.288T7 17v1q0 .425-.288.713T6 19q.425 0 .713.288T7 20v1q0 .425-.288.713T6 22zm0-7v-2.75q0-.425.288-.712T4 11.25h1.5v-.75H3V9h3q.425 0 .713.288T7 10v1.75q0 .425-.288.713T6 12.75H4.5v.75H7V15zm1.5-7V3.5H3V2h3v6zM9 19v-2h12v2zm0-6v-2h12v2zm0-6V5h12v2z">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-l border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('justifyLeft')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 21v-2h18v2zm0-4v-2h12v2zm0-4v-2h18v2zm0-4V7h12v2zm0-4V3h18v2z">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('justifyCenter')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 21v-2h18v2zm4-4v-2h10v2zm-4-4v-2h18v2zm4-4V7h10v2zM3 5V3h18v2z">
                                </svg>
                            </button>
                            <button type="button"
                                class="h-10 w-10 border-r border-gray-200 outline-none hover:text-indigo-500 focus:outline-none active:bg-gray-50"
                                @click="format('justifyRight')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M4 5q-.425 0-.712-.288T3 4t.288-.712T4 3h16q.425 0 .713.288T21 4t-.288.713T20 5zm6 4q-.425 0-.712-.288T9 8t.288-.712T10 7h6q.425 0 .713.288T21 8t-.288.713T20 9zm-6 4q-.425 0-.712-.288T9 12t.288-.712T10 11h6q.425 0 .713.288T21 12t-.288.713T20 13zm6 4q-.425 0-.712-.288T9 16t.288-.712T10 15h6q.425 0 .713.288T21 16t-.288.713T20 17zm-6 4q-.425 0-.712-.288T9 20t.288-.712T10 19h6q.425 0 .713.288T21 20t-.288.713T20 21z">
                                </svg>
                            </button>
                        </div>
                        <div class="w-full">
                            <iframe x-ref="wysiwyg" class="h-96 w-full overflow-y-auto"></iframe>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                        class="font-medium">{{ __('create_article.oops') }}!</span> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catégorie -->
            <div class="mb-6">
                <label for="article_category_id"
                    class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_article.category') }}*</label>
                <select name="article_category_id" id="article_category_id"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 transition focus:border-green-gs focus:ring-2 focus:ring-green-gs font-roboto-slab"
                    required>
                    <option value="">{{ __('create_article.select_category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                            class="font-medium">{{ __('create_article.oops') }}!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Tags - Nouvelle implémentation -->
            <div class="mb-6">
                <label class="mb-2 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_article.tags') }}</label>

                <!-- Champ de recherche et sélection -->
                <div class="relative mb-3">
                    <input type="text" x-model="tagSearch" x-on:input.debounce.300ms="searchTags()"
                        x-on:keydown.enter.prevent="handleTagEnter" x-ref="tagInput"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 transition focus:border-green-gs focus:ring-2 focus:ring-green-gs font-roboto-slab"
                        placeholder="{{ __('create_article.search_or_add_tags') }}">

                    <!-- Suggestions de tags -->
                    <div x-show="tagSuggestions.length > 0 && tagSearch.length > 0" x-transition
                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md border border-gray-200 bg-white shadow-lg">
                        <template x-for="tag in tagSuggestions" :key="tag.id">
                            <div x-on:click="addTag(tag)"
                                class="flex cursor-pointer items-center justify-between px-4 py-2 hover:bg-green-gs">
                                <span x-text="tag.name"></span>
                                <span class="text-xs text-gray-500">{{ __('create_article.exists') }}</span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Option pour créer un nouveau tag -->
                <div x-show="showCreateTagOption" x-transition class="mb-3">
                    <div class="flex items-center justify-between rounded-md bg-gray-50 p-3">
                        <span class="text-sm">
                            {{ __('create_article.tag_does_not_exist') }}
                            "<span x-text="tagSearch" class="font-medium"></span>"
                        </span>
                        <button type="button" x-on:click="openCreateTagModal()"
                            class="rounded bg-green-gs px-3 py-1 text-sm text-white hover:bg-green-gs/80">
                            {{ __('create_article.create_tag') }}
                        </button>
                    </div>
                </div>

                <!-- Tags sélectionnés -->
                <div class="flex flex-wrap gap-2">
                    <template x-for="tag in selectedTags" :key="tag.id">
                        <div class="inline-flex items-center rounded-full bg-supaGirlRosePastel px-3 py-1 text-sm text-green-gs font-roboto-slab">
                            <span x-text="tag.name"></span>
                            <button type="button" x-on:click="removeTag(tag.id)"
                                class="ml-2 text-green-gs hover:text-green-gs">
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
                        class="h-4 w-4 rounded border-gray-300 text-green-gs font-roboto-slab focus:ring-green-gs">
                    <label for="is_published"
                        class="ml-2 block text-sm text-gray-700 font-roboto-slab">{{ __('create_article.publish_article') }}</label>
                </div>
            </div>

            <!-- Date de publication -->
            <div x-show="isPublished" x-transition class="mb-6">
                <label for="published_at"
                    class="mb-1 block text-sm font-medium text-gray-700">{{ __('create_article.publication_date') }}</label>
                <input type="datetime-local" name="published_at" id="published_at" x-model="publishedAt"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 transition focus:border-green-gs focus:ring-2 focus:ring-green-gs font-roboto-slab">
                @error('published_at')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                            class="font-medium">{{ __('create_article.oops') }}!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton de soumission -->
            <div class="flex justify-end">
                <button type="submit" class="bg-green-gs text-white px-4 py-2 text-sm font-roboto-slab hover:bg-white hover:text-green-gs transition rounded-lg">
                    {{ __('create_article.create_article') }}
                </button>
            </div>
        </form>

        <!-- icici -->

        <!-- Modale de création de tag -->
        <div x-show="showTagModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div x-on:click.away="closeCreateTagModal" class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                <h3 class="mb-4 text-lg font-medium text-green-gs font-roboto-slab">{{ __('create_article.create_new_tag') }}</h3>

                <div class="mb-4">
                    <label for="newTagName"
                        class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_article.tag_name') }}*</label>
                    <input type="text" id="newTagName" x-model="tagSearch"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" x-on:click="closeCreateTagModal"
                        class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">
                        {{ __('create_article.cancel') }}
                    </button>
                    <button type="button" x-on:click="createNewTag" class="rounded-md bg-green-gs text-white px-4 py-2 text-sm font-roboto-slab hover:bg-white hover:text-green-gs transition">
                        {{ __('create_article.create_tag') }}
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
                isPublished: false,
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
                                    arr[i - 1][j] + 1, arr[i][j - 1] + 1, arr[i - 1][j - 1] + (s[j - 1] === t[i - 1] ? 0 :
                                        1)
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
                        console.log("ici",data);

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
                    this.content = this.wysiwyg.contentDocument.body.outHTML;
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
