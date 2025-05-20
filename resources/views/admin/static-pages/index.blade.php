@extends('layouts.admin')

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-lg bg-white p-6 shadow">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('static_pages.static_pages') }}</h1>
                    <a href="{{ route('static-pages.create') }}"
                        class="btn-gs-gradient flex items-center rounded-lg px-4 py-2">
                        <i class="fas fa-plus mr-2"></i> {{ __('static_pages.new_page') }}
                    </a>
                </div>

                <div class="overflow-x-auto">
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
                                            class="text-indigo-600 hover:text-indigo-900">{{ __('static_pages.edit') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
