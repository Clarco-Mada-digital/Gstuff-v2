@extends('layouts.admin')

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8 font-roboto-slab" x-data="{ content: `{{ addslashes($staticPage->content) }}` }">
        <div class="mx-auto max-w-7xl">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('static_pages.edit_static_page') }}</h1>
                <a href="{{ route('static.index') }}" class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 
                rounded-md  shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i> {{ __('static_pages.back') }}
                </a>
            </div>
            <div class="rounded-lg bg-white p-6 shadow">

                <form action="{{ route('static.update', $staticPage) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('static_pages.title') }}</label>
                            <input type="hidden" name="lang" value="{{ app()->getLocale() }}">
                        <input type="text" name="title" id="title" value="{{ old('title', $staticPage->title) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-gs focus:ring-green-gs">
                    </div>

                    <div class="mb-6" wire:ignore>
                        <label class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('static_pages.content') }}</label>
                        <div wire:ignore>
                            <textarea id="editor" x-model="content" name="content" class="hidden">{{ old('content', $staticPage->content) }}</textarea>
                            <div id="editor-container" class="min-h-[300px] rounded-lg border" x-html="content"></div>
                        </div>
                    </div>

                    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="meta_title"
                                class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('static_pages.meta_title') }}</label>
                            <input type="text" name="meta_title" id="meta_title"
                                value="{{ old('meta_title', $staticPage->meta_title) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-gs focus:ring-green-gs">
                        </div>
                        <div>
                            <label for="meta_description"
                                class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('static_pages.meta_description') }}</label>
                            <textarea name="meta_description" id="meta_description" rows="2"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-gs focus:ring-green-gs">{{ old('meta_description', $staticPage->meta_description) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('static.index') }}"
                            class="flex items-center rounded-sm bg-white text-green-gs px-4 py-2 transition duration-200 hover:bg-green-gs/80 hover:text-white">
                            {{ __('static_pages.cancel') }}
                        </a>
                        <button type="submit" class="bg-green-gs text-white flex items-center rounded-sm px-4 py-2 hover:bg-green-gs/80 transition rounded-sm shadow-md">
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
