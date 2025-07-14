@extends('layouts.admin')

@php
    use Illuminate\Support\Str;
@endphp

@section('pageTitle')
    {{ __('comments.comments_management') }}
@endsection

@section('admin-content')
    <div x-data="{ selectedTab: 'approved' }" class="container mx-auto min-h-[100vh] px-4 py-8 pt-16">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('comments.comments_management') }}</h1>
        </div>

        <nav class="bg-gray-50 dark:bg-gray-700 font-roboto-slab">
            <div class="max-w-screen-xl px-4 py-3">
                <div class="flex items-center">
                    <ul class="flex flex-row space-x-8 text-sm font-medium font-roboto-slab">
                        <li>
                            <a href="#" @click="selectedTab = 'approved'"
                                :class="{ 'bg-blue-500 text-white': selectedTab === 'approved', 'text-gray-900 dark:text-white': selectedTab !== 'approved' }"
                                class="flex items-center rounded px-4 py-2 hover:bg-blue-300">
                                <i class="fas fa-check-circle mr-2"></i> {{ __('comments.approved') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" @click="selectedTab = 'non-approved'"
                                :class="{ 'bg-blue-500 text-white': selectedTab === 'non-approved', 'text-gray-900 dark:text-white': selectedTab !== 'non-approved' }"
                                class="flex items-center rounded px-4 py-2 hover:bg-blue-300">
                                <i class="fas fa-times-circle mr-2"></i> {{ __('comments.non_approved') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Pour les commentaires approuvés --}}
        <div x-show="selectedTab === 'approved'" class="px-4 py-3">
            <h2 class="mb-5 font-roboto-slab">{{ __('comments.approved_comments_list') }}</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.email') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.content') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.date') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.actions') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($commentairesApproved as $commentaire)
                        <tr class="approved-item">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100">
                                        {{ substr($commentaire->user->pseudo ?? ($commentaire->user->prenom ?? $commentaire->user->nom_salon), 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $commentaire->user->pseudo ?? ($commentaire->user->prenom ?? $commentaire->user->nom_salon) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-roboto-slab text-gray-500">{{ $commentaire->user->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4 font-roboto-slab">
                                <div class="flex flex-wrap gap-1">
                                    {{ Str::limit($commentaire->content, 80, '...') }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-roboto-slab">
                                <div class="flex flex-wrap gap-1">
                                    {{ \Carbon\Carbon::parse($commentaire->created_at)->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-roboto-slab">
                                @if ($commentaire->read_at)
                                    <p class="text-xs text-green-500">{{ __('comments.read') }} :
                                        {{ $commentaire->read_at }}</p>
                                @else
                                    <p class="text-xs text-red-500">{{ __('comments.not_read') }}</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                <a href="{{ route('commentaires.show', $commentaire->id) }}"
                                    class="mr-3 text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('{{ __('comments.delete_confirmation') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 flex justify-center space-x-4">
                <button onclick="prevPageApproved()" class="flex items-center rounded-lg bg-gray-300 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <span id="page-info-approved" class="px-4 py-2 font-semibold"></span>
                <button onclick="nextPageApproved()" class="flex items-center rounded-lg bg-gray-300 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Pour les commentaires non approuvés --}}
        <div x-show="selectedTab === 'non-approved'" class="px-4 py-3">
            <h2 class="mb-5 font-roboto-slab">{{ __('comments.non_approved_comments_list') }}</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.email') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.content') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.date') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 font-roboto-slab">
                            {{ __('comments.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white font-roboto-slab">
                    @foreach ($commentairesNotApproved as $commentaire)
                        <tr class="non-approved-item">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100">
                                        {{ substr($commentaire->user->pseudo ?? ($commentaire->user->prenom ?? $commentaire->user->nom_salon), 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $commentaire->user->pseudo ?? ($commentaire->user->prenom ?? $commentaire->user->nom_salon) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-500">{{ $commentaire->user->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    {{ Str::limit($commentaire->content, 80, '...') }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    {{ \Carbon\Carbon::parse($commentaire->created_at)->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($commentaire->read_at)
                                    <p class="text-xs text-green-500">{{ __('comments.read') }} :
                                        {{ $commentaire->read_at }}</p>
                                @else
                                    <p class="text-xs text-red-500">{{ __('comments.not_read') }}</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">
                                <a href="{{ route('commentaires.show', $commentaire->id) }}"
                                    class="mr-3 text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('{{ __('comments.delete_confirmation') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 flex justify-center space-x-4">
                <button onclick="prevPageNonApproved()" class="flex items-center rounded-lg bg-gray-300 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <span id="page-info-non-approved" class="px-4 py-2 font-semibold"></span>
                <button onclick="nextPageNonApproved()" class="flex items-center rounded-lg bg-gray-300 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let itemsPerPageApproved = 4;
        let currentPageApproved = 1;
        let approvedComments = document.querySelectorAll(".approved-item");
        let totalPagesApproved = Math.ceil(approvedComments.length / itemsPerPageApproved);

        function showPageApproved(page) {
            let start = (page - 1) * itemsPerPageApproved;
            let end = start + itemsPerPageApproved;

            approvedComments.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "table-row" : "none";
            });

            document.getElementById("page-info-approved").innerText =
                `Page ${currentPageApproved} / ${totalPagesApproved}`;
        }

        window.nextPageApproved = function() {
            if (currentPageApproved < totalPagesApproved) {
                currentPageApproved++;
                showPageApproved(currentPageApproved);
            }
        };

        window.prevPageApproved = function() {
            if (currentPageApproved > 1) {
                currentPageApproved--;
                showPageApproved(currentPageApproved);
            }
        };

        showPageApproved(currentPageApproved);
    });

    document.addEventListener("DOMContentLoaded", function() {
        let itemsPerPageNonApproved = 4;
        let currentPageNonApproved = 1;
        let nonApprovedComments = document.querySelectorAll(".non-approved-item");
        let totalPagesNonApproved = Math.ceil(nonApprovedComments.length / itemsPerPageNonApproved);

        function showPageNonApproved(page) {
            let start = (page - 1) * itemsPerPageNonApproved;
            let end = start + itemsPerPageNonApproved;

            nonApprovedComments.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "table-row" : "none";
            });

            document.getElementById("page-info-non-approved").innerText =
                `Page ${currentPageNonApproved} / ${totalPagesNonApproved}`;
        }

        window.nextPageNonApproved = function() {
            if (currentPageNonApproved < totalPagesNonApproved) {
                currentPageNonApproved++;
                showPageNonApproved(currentPageNonApproved);
            }
        };

        window.prevPageNonApproved = function() {
            if (currentPageNonApproved > 1) {
                currentPageNonApproved--;
                showPageNonApproved(currentPageNonApproved);
            }
        };

        showPageNonApproved(currentPageNonApproved);
    });
</script>
