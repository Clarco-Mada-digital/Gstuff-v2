@extends('layouts.admin')

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-lg bg-white p-6 shadow">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('static_page-create.create_new_page') }}</h1>
                    <a href="{{ route('static.index') }}" class="btn-gs-gradient flex items-center rounded-lg px-4 py-2">
                        <i class="fas fa-arrow-left mr-2"></i> {{ __('static_page-create.back') }}
                    </a>
                </div>

                <form action="{{ route('static.store') }}" method="POST">
                    @csrf

                    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="slug"
                                class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_page-create.slug') }}*</label>
                            <input type="text" name="slug" id="slug" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="{{ __('static_page-create.slug_placeholder') }}">
                            <p class="mt-1 text-sm text-gray-500">{{ __('static_page-create.slug_unique') }}</p>
                        </div>
                        <div>
                            <label for="title"
                                class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_page-create.title') }}*</label>
                            <input type="text" name="title" id="title" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section Contenu avec CKEditor -->
                    <div class="mb-6">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_page-create.content') }}*</label>
                        <textarea id="editor" name="content" class="hidden" required></textarea>
                        <div id="editor-container" class="min-h-[300px] rounded-lg border"></div>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="meta_title"
                                class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_page-create.meta_title') }}</label>
                            <input type="text" name="meta_title" id="meta_title"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="meta_description"
                                class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_page-create.meta_description') }}</label>
                            <textarea name="meta_description" id="meta_description" rows="2"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="reset" class="btn-green-400 flex items-center rounded-lg px-4 py-2">
                            {{ __('static_page-create.reset') }}
                        </button>
                        <button type="submit" class="btn-gs-gradient flex items-center rounded-lg px-4 py-2">
                            <i class="fas fa-save mr-2"></i> {{ __('static_page-create.create_page') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- CKEditor 5 -->
        <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialisation de CKEditor
                ClassicEditor
                    .create(document.querySelector('#editor-container'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'link', '|',
                            'bulletedList', 'numberedList', '|',
                            'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        // Synchronisation avec le textarea caché
                        editor.model.document.on('change:data', () => {
                            document.querySelector('#editor').value = editor.getData();
                        });

                        // Validation initiale
                        document.querySelector('form').addEventListener('submit', function(e) {
                            if (editor.getData().trim() === '') {
                                e.preventDefault();
                                alert('Le contenu est requis');
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Erreur CKEditor:', error);
                    });

                // Génération automatique du slug
                document.getElementById('title').addEventListener('input', function() {
                    const slugInput = document.getElementById('slug');
                    if (!slugInput.value) {
                        slugInput.value = this.value
                            .toLowerCase()
                            .replace(/[^\w\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                    }
                });
            });
        </script>
    @endpush
@endsection
