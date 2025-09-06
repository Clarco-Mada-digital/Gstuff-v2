@extends('layouts.admin')

@section('admin-content')
    <div class="font-roboto-slab px-4 py-6 sm:px-6 lg:px-8" x-data="{ content: `{{ addslashes($staticPage->content) }}` }">
        <div class="mx-auto max-w-7xl">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-green-gs font-roboto-slab text-2xl font-bold">{{ __('static_pages.edit_static_page') }}</h1>
                <a href="{{ route('static.index') }}"
                    class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i> {{ __('static_pages.back') }}
                </a>
            </div>
            <div class="rounded-lg bg-white p-6 shadow">

                <form action="{{ route('static.update', $staticPage) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title"
                            class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('static_pages.title') }}</label>
                        <input type="hidden" name="lang" value="{{ app()->getLocale() }}">
                        <input type="text" name="title" id="title" value="{{ old('title', $staticPage->title) }}"
                            class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-6" wire:ignore>
                        <label
                            class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('static_pages.content') }}</label>
                        <div wire:ignore>
                            <textarea id="editor" x-model="content" name="content" class="hidden">{{ old('content', $staticPage->content) }}</textarea>
                            <div id="editor-container" class="min-h-[300px] rounded-lg border" x-html="content"></div>
                        </div>
                    </div>

                    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="meta_title"
                                class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('static_pages.meta_title') }}</label>
                            <input type="text" name="meta_title" id="meta_title"
                                value="{{ old('meta_title', $staticPage->meta_title) }}"
                                class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="meta_description"
                                class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('static_pages.meta_description') }}</label>
                            <textarea name="meta_description" id="meta_description" rows="2"
                                class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border-gray-300 shadow-sm">{{ old('meta_description', $staticPage->meta_description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('static.index') }}"
                            class="text-green-gs hover:bg-green-gs/80 flex items-center rounded-sm bg-white px-4 py-2 transition duration-200 hover:text-white">
                            {{ __('static_pages.cancel') }}
                        </a>
                        <button type="submit"
                            class="bg-green-gs hover:bg-green-gs/80 flex items-center rounded-sm rounded-sm px-4 py-2 text-white shadow-md transition">
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
