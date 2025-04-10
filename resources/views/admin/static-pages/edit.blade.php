<!-- resources/views/admin/static-pages/edit.blade.php -->
@extends('layouts.admin')

@section('admin-content')
<div class="py-6 px-4 sm:px-6 lg:px-8" x-data="{ content: `{{ addslashes($staticPage->content) }}` }">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center p-6">
            <h1 class="text-2xl font-bold text-gray-900">Pages Statiques</h1>
            <a href="{{ route('static.create') }}" class="btn-gs-gradient rounded-lg px-4 py-2 flex items-center">
                <i class="fas fa-plus mr-2"></i> Nouvelle page
            </a>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            
            <form action="{{ route('static.update', $staticPage) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $staticPage->title) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                
                <div class="mb-6" wire:ignore>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
                    <div wire:ignore>
                        <textarea id="editor" x-model="content" name="content" class="hidden">{{ old('content', $staticPage->content) }}</textarea>
                        <div id="editor-container" class="min-h-[300px] border rounded-lg" x-html="content"></div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $staticPage->meta_title) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('meta_description', $staticPage->meta_description) }}</textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('static.index') }}" class="bg-red-500 text-white rounded-lg px-4 py-2 flex items-center hover:bg-red-600 transition duration-200">
                        Annuler
                    </a>
                    <button type="submit" class="btn-gs-gradient rounded-lg px-4 py-2 flex items-center">
                        Enregistrer
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
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
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