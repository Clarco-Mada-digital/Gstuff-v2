@extends('layouts.admin')

@section('pageTitle')
Commentaire
@endsection

@section('admin-content')
<div x-data="{ selectedTab: 'approved' }" class="md:ml-64 pt-16 min-h-[100vh] container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Commentaires</h1>
    </div>

    <nav class="bg-gray-50 dark:bg-gray-700">
        <div class="max-w-screen-xl px-4 py-3">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium space-x-8 text-sm">
                    <li>
                        <a href="#" @click="selectedTab = 'approved'"
                            :class="{ 'bg-blue-500 text-white': selectedTab === 'approved', 'text-gray-900 dark:text-white': selectedTab !== 'approved' }"
                            class="hover:bg-blue-300 px-4 py-2 rounded">Approuvés</a>
                    </li>
                    <li>
                        <a href="#" @click="selectedTab = 'non-approved'"
                            :class="{ 'bg-blue-500 text-white': selectedTab === 'non-approved', 'text-gray-900 dark:text-white': selectedTab !== 'non-approved' }"
                            class="hover:bg-blue-300 px-4 py-2 rounded">Non Approuvés</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Pour les commentaires approuvés --}}
    <div x-show="selectedTab === 'approved'" class="px-4 py-3">
        <h2 class="mb-5">Liste des Commentaires Approuvés</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden w-full p-4">
            <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 font-medium text-gray-500 uppercase text-xs">
                <div>Contenu</div>
                <div>Utilisateur</div>
                <div>Date</div>
                <div>Actions</div>
            </div>

            <div id="approved-list">
                @foreach($commentairesApproved as $commentaire)
                <div class="grid grid-cols-4 gap-4 p-2 border-b border-gray-200 approved-item">
                    <div class="px-4 py-2">{{ $commentaire->content }}</div>
                    <div class="px-4 py-2">{{ $commentaire->user->prenom ?? 'Utilisateur inconnu' }}</div>
                    <div class="px-4 py-2">{{ $commentaire->created_at->format('d/m/Y H:i') }}</div>
                    <div class="px-4 py-2 text-gray-500">
                        <a href="#" class="text-blue-500 underline">Voir</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contrôles de pagination -->
            <div class="flex justify-center mt-4 space-x-4">
                <button onclick="prevPageApproved()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <span id="page-info-approved" class="px-4 py-2 font-semibold"></span>

                <button onclick="nextPageApproved()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Pour les commentaires non approuvés --}}
    <div x-show="selectedTab === 'non-approved'" class="px-4 py-3">
        <h2 class="mb-5">Liste des Commentaires Non Approuvés</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden w-full p-4">
            <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 font-medium text-gray-500 uppercase text-xs">
                <div>Contenu</div>
                <div>Utilisateur</div>
                <div>Date</div>
                <div>Actions</div>
            </div>

            <div id="non-approved-list">
                @foreach($commentairesNotApproved as $commentaire)
                <div class="grid grid-cols-4 gap-4 p-2 border-b border-gray-200 non-approved-item">
                    <div class="px-4 py-2">{{ $commentaire->content }}</div>
                    <div class="px-4 py-2">{{ $commentaire->user->prenom ?? 'Utilisateur inconnu' }}</div>
                    <div class="px-4 py-2">{{ $commentaire->created_at->format('d/m/Y H:i') }}</div>
                    <div class="px-4 py-2 text-gray-500">
                        <a href="#" class="text-blue-500 underline">Voir</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contrôles de pagination -->
            <div class="flex justify-center mt-4 space-x-4">
                <button onclick="prevPageNonApproved()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <span id="page-info-non-approved" class="px-4 py-2 font-semibold"></span>

                <button onclick="nextPageNonApproved()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let itemsPerPageApproved = 4;
        let currentPageApproved = 1;
        let approvedComments = document.querySelectorAll(".approved-item");
        let totalPagesApproved = Math.ceil(approvedComments.length / itemsPerPageApproved);

        function showPageApproved(page) {
            let start = (page - 1) * itemsPerPageApproved;
            let end = start + itemsPerPageApproved;

            approvedComments.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "grid" : "none";
            });

            document.getElementById("page-info-approved").innerText = `Page ${currentPageApproved} / ${totalPagesApproved}`;
        }

        window.nextPageApproved = function () {
            if (currentPageApproved < totalPagesApproved) {
                currentPageApproved++;
                showPageApproved(currentPageApproved);
            }
        };

        window.prevPageApproved = function () {
            if (currentPageApproved > 1) {
                currentPageApproved--;
                showPageApproved(currentPageApproved);
            }
        };

        showPageApproved(currentPageApproved);
    });

    document.addEventListener("DOMContentLoaded", function () {
        let itemsPerPageNonApproved = 4;
        let currentPageNonApproved = 1;
        let nonApprovedComments = document.querySelectorAll(".non-approved-item");
        let totalPagesNonApproved = Math.ceil(nonApprovedComments.length / itemsPerPageNonApproved);

        function showPageNonApproved(page) {
            let start = (page - 1) * itemsPerPageNonApproved;
            let end = start + itemsPerPageNonApproved;

            nonApprovedComments.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "grid" : "none";
            });

            document.getElementById("page-info-non-approved").innerText = `Page ${currentPageNonApproved} / ${totalPagesNonApproved}`;
        }

        window.nextPageNonApproved = function () {
            if (currentPageNonApproved < totalPagesNonApproved) {
                currentPageNonApproved++;
                showPageNonApproved(currentPageNonApproved);
            }
        };

        window.prevPageNonApproved = function () {
            if (currentPageNonApproved > 1) {
                currentPageNonApproved--;
                showPageNonApproved(currentPageNonApproved);
            }
        };

        showPageNonApproved(currentPageNonApproved);
    });
</script>
