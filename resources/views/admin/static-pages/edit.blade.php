@extends('layouts.admin')

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8" x-data="{ content: `{{ addslashes($staticPage->content) }}` }">
        <div class="mx-auto max-w-7xl">
            <div class="flex items-center justify-between p-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ __('static_pages.static_pages') }}</h1>
                <a href="{{ route('static.create') }}" class="btn-gs-gradient flex items-center rounded-lg px-4 py-2">
                    <i class="fas fa-plus mr-2"></i> {{ __('static_pages.new_page') }}
                </a>
            </div>
            <div class="rounded-lg bg-white p-6 shadow">

                <form action="{{ route('static.update', $staticPage) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title"
                            class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_pages.title') }}</label>
                            <input type="hidden" name="lang" value="{{ app()->getLocale() }}">
                        <input type="text" name="title" id="title" value="{{ old('title', $staticPage->title) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mb-6" wire:ignore>
                        <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_pages.content') }}</label>
                        <div wire:ignore>
                            <textarea id="editor" x-model="content" name="content" class="hidden">{{ old('content', $staticPage->content) }}</textarea>
                            <div id="editor-container" class="min-h-[300px] rounded-lg border" x-html="content"></div>
                        </div>
                    </div>

                    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="meta_title"
                                class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_pages.meta_title') }}</label>
                            <input type="text" name="meta_title" id="meta_title"
                                value="{{ old('meta_title', $staticPage->meta_title) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="meta_description"
                                class="mb-1 block text-sm font-medium text-gray-700">{{ __('static_pages.meta_description') }}</label>
                            <textarea name="meta_description" id="meta_description" rows="2"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('meta_description', $staticPage->meta_description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('static.index') }}"
                            class="flex items-center rounded-lg bg-red-500 px-4 py-2 text-white transition duration-200 hover:bg-red-600">
                            {{ __('static_pages.cancel') }}
                        </a>
                        <button type="submit" class="btn-gs-gradient flex items-center rounded-lg px-4 py-2">
                            {{ __('static_pages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                ClassicEditor
                    .create(document.querySelector('#editor-container'), {
                        initialData: document.querySelector('#editor').value,
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                            'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            const content = editor.getData();
                            document.querySelector('#editor').value = content;
                            Alpine.$data(document.querySelector('[x-data]')).content = content;
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        </script>
    @endpush
@endsection
