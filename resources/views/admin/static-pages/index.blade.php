@extends('layouts.admin')

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-lg bg-white p-6 shadow">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('static_pages.static_pages') }}</h1>
                    <a href="{{ route('static-pages.create') }}"
                        class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 rounded-md shadow-md">
                        <i class="fas fa-plus mr-2"></i> {{ __('static_pages.new_page') }}
                    </a>
                </div>
                <div class="overflow-x-auto font-roboto-slab">
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
                                            class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 rounded-md shadow-md">{{ __('static_pages.edit') }}</a>
                                        <button onclick="openModal({{ $page->id }})"
                                            class="bg-red-500 text-white px-4 py-2 font-roboto-slab hover:bg-red-500/80 rounded-md shadow-md">{{ __('static_pages.delete') }}</button>
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
    <div id="confirmationModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h2 class="text-xl font-roboto-slab mb-4 text-green-gs">{{ __('static_pages.confirm_delete') }}</h2>
            <p class="text-textColorParagraph">{{ __('static_pages.delete_confirmation_message') }}</p>
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="closeModal()" class=" cursor-pointer px-4 py-2 bg-white text-green-gs border border-green-gs font-roboto-slab rounded-md">{{ __('static_pages.cancel') }}</button>
                <button onclick="deletePage()" class=" cursor-pointer px-4 py-2 bg-red-500 text-white font-roboto-slab rounded-md">{{ __('static_pages.delete') }}</button>
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
