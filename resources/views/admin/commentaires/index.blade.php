@extends('layouts.admin')

@section('pageTitle')
Commentaires
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

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contenu
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($commentairesApproved as $commentaire)
                <tr class="approved-item">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                {{ substr($commentaire->user->pseudo ?? $commentaire->user->prenom ??
                                $commentaire->user->nom_salon, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $commentaire->user->pseudo ??
                                    $commentaire->user->prenom ?? $commentaire->user->nom_salon }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $commentaire->user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-wrap gap-1">
                            {{ $commentaire->content }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                        <a 
                        href="{{ route('commentaires.show', $commentaire->id) }}"
                         class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        {{-- <a href="{{ route('users.edit', $commentaire->user) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a> --}}
                       
                        <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet Commentaire ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach
            </tbody>
            <!-- Contrôles de pagination -->

        </table>
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

    {{-- Pour les commentaires non approuvés --}}
    <div x-show="selectedTab === 'non-approved'" class="px-4 py-3">
        <h2 class="mb-5">Liste des Commentaires Non Approuvés</h2>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contenu
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($commentairesNotApproved as $commentaire)
                <tr class="non-approved-item">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                {{ substr($commentaire->user->pseudo ?? $commentaire->user->prenom ??
                                $commentaire->user->nom_salon, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $commentaire->user->pseudo ??
                                    $commentaire->user->prenom ?? $commentaire->user->nom_salon }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $commentaire->user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-wrap gap-1">
                            {{ $commentaire->content }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                        <a 
                        href="{{ route('commentaires.show', $commentaire->id) }}"
                         class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        {{-- <a href="{{ route('users.edit', $commentaire->user) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a> --}}
                       
                        <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet Commentaire ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                    
                </tr>

                @endforeach
            </tbody>



        </table>
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
            item.style.display = index >= start && index < end ? "table-row" : "none";
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
                item.style.display = index >= start && index < end ? "table-row" : "none";
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