@extends('layouts.admin')

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-lg bg-white p-6 shadow">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-green-gs font-roboto-slab text-2xl font-bold">{{ __('static_pages.static_pages') }}</h1>
                    <a href="{{ route('static-pages.create') }}"
                        class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                        <i class="fas fa-plus mr-2"></i> {{ __('static_pages.new_page') }}
                    </a>
                </div>
                <div class="font-roboto-slab overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    {{ __('static_pages.title') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                    {{ __('static_pages.slug') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                    {{ __('static_pages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($pages as $page)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $page->title }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $page->slug }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('static.edit', $page->id) }}"
                                            class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">{{ __('static_pages.edit') }}</a>
                                        <button onclick="openModal({{ $page->id }})"
                                            class="font-roboto-slab rounded-md bg-red-500 px-4 py-2 text-white shadow-md hover:bg-red-500/80">{{ __('static_pages.delete') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/50">
        <div class="w-1/3 rounded-lg bg-white p-6 shadow-lg">
            <h2 class="font-roboto-slab text-green-gs mb-4 text-xl">{{ __('static_pages.confirm_delete') }}</h2>
            <p class="text-textColorParagraph">{{ __('static_pages.delete_confirmation_message') }}</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="closeModal()"
                    class="text-green-gs border-green-gs font-roboto-slab cursor-pointer rounded-md border bg-white px-4 py-2">{{ __('static_pages.cancel') }}</button>
                <button onclick="deletePage()"
                    class="font-roboto-slab cursor-pointer rounded-md bg-red-500 px-4 py-2 text-white">{{ __('static_pages.delete') }}</button>
            </div>
        </div>
    </div>

    <script>
        let pageIdToDelete;

        function openModal(pageId) {
            pageIdToDelete = pageId;
            document.getElementById('confirmationModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmationModal').classList.add('hidden');
        }

        function deletePage() {
            axios.delete(`admin/static-pg/${pageIdToDelete}`)
                .then(response => {
                    // alert(response.data.message);
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                    alert(error.response.data.message);
                })
                .finally(() => {
                    closeModal();
                });
        }
    </script>
@endsection
