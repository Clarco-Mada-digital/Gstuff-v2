@extends('layouts.admin')

@section('pageTitle')
Utilisateur
@endsection

@section('admin-content')
<div x-data="{ selectedTab: 'salon' }" class="md:ml-64 pt-16 min-h-[100vh] container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des utilisateurs</h1>
    </div>

    <nav class="bg-gray-50 dark:bg-gray-700">
        <div class="max-w-screen-xl px-4 py-3">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium space-x-8 text-sm">
                    <li>
                        <a href="#" @click="selectedTab = 'salon'"
                            :class="{ 'bg-blue-500 text-white': selectedTab === 'salon', 'text-gray-900 dark:text-white': selectedTab !== 'salon' }"
                            class="hover:bg-blue-300 px-4 py-2 rounded">Salon</a>
                    </li>
                    <li>
                        <a href="#" @click="selectedTab = 'escort'"
                            :class="{ 'bg-blue-500 text-white': selectedTab === 'escort', 'text-gray-900 dark:text-white': selectedTab !== 'escort' }"
                            class="hover:bg-blue-300 px-4 py-2 rounded">Escort</a>
                    </li>
                    <li>
                        <a href="#" @click="selectedTab = 'invite'"
                            :class="{ 'bg-blue-500 text-white': selectedTab === 'invite', 'text-gray-900 dark:text-white': selectedTab !== 'invite' }"
                            class="hover:bg-blue-300 px-4 py-2 rounded">Invite</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Pour le salon --}}
    <div x-show="selectedTab === 'salon'" class="px-4 py-3">
        <h2 class="mb-5">Liste des salons</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden w-full p-4">
            <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 font-medium text-gray-500 uppercase text-xs">
                <div>Nom salon</div>
                <div>Email</div>
                <div>Date</div>
                <div>Actions</div>
            </div>

            <div id="salon-list">
                @foreach($usersSalons as $item)
                <div class="grid grid-cols-4 gap-4 p-2 border-b border-gray-200 salon-item">
                    <div class="px-4 py-2">{{ $item->prenom ?? 'Utilisateur inconnu' }}</div>
                    <div class="px-4 py-2">{{ $item->email ?? 'Email non disponible' }}</div>
                    <div class="px-4 py-2">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                    <div class="px-4 py-2 text-gray-500">
                        <a href="#" class="text-blue-500 underline">Voir</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contrôles de pagination -->
            <div class="flex justify-center mt-4 space-x-4">
                <button onclick="prevPageSalon()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <span id="page-info-salon" class="px-4 py-2 font-semibold"></span>

                <button onclick="nextPageSalon()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Pour le escort --}}
    <div x-show="selectedTab === 'escort'" class="px-4 py-3">
        <h2 class="mb-5">Liste des demandes de vérification de profil</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden w-full p-4">
            <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 font-medium text-gray-500 uppercase text-xs">
                <div>Nom</div>
                <div>Email</div>
                <div>Date</div>
                <div>Actions</div>
            </div>

            <div id="notification-list">
                @foreach($notificationsWithUsers as $item)
                <div class="grid grid-cols-4 gap-4 p-2 border-b border-gray-200 notification-item">
                    <div class="px-4 py-2">{{ $item['user']->prenom ?? 'Utilisateur inconnu' }}</div>
                    <div class="px-4 py-2">{{ $item['user']->email ?? 'Email non disponible' }}</div>
                    <div class="px-4 py-2">{{ $item['notification']->created_at->format('d/m/Y H:i') }}</div>
                    <div class="px-4 py-2 text-gray-500">
                        <a href="#" class="text-blue-500 underline">Voir</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contrôles de pagination -->
            <div class="flex justify-center mt-4 space-x-4">
                <button onclick="prevPageNotification()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <span id="page-info-notification" class="px-4 py-2 font-semibold"></span>

                <button onclick="nextPageNotification()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <h2 class="mb-5 mt-5">Liste des escortes</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden w-full p-4">
            <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 font-medium text-gray-500 uppercase text-xs">
                <div>Nom</div>
                <div>Email</div>
                <div>Date</div>
                <div>Actions</div>
            </div>

            <div id="escort-list">
                @foreach($usersEscortes as $item)
                <div class="grid grid-cols-4 gap-4 p-2 border-b border-gray-200 escort-item">
                    <div class="px-4 py-2">{{ $item->prenom ?? 'Utilisateur inconnu' }}</div>
                    <div class="px-4 py-2">{{ $item->email ?? 'Email non disponible' }}</div>
                    <div class="px-4 py-2">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                    <div class="px-4 py-2 text-gray-500">
                        <a href="#" class="text-blue-500 underline">Voir</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contrôles de pagination -->
            <div class="flex justify-center mt-4 space-x-4">
                <button onclick="prevPageEscort()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <span id="page-info-escort" class="px-4 py-2 font-semibold"></span>

                <button onclick="nextPageEscort()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Pour le Invite --}}
    <div x-show="selectedTab === 'invite'" class="px-4 py-3">
        <h2 class="mb-5">Liste des Invites</h2>
        <div class="bg-white shadow rounded-lg overflow-hidden w-full p-4">
            <div class="grid grid-cols-4 gap-4 bg-gray-50 p-2 font-medium text-gray-500 uppercase text-xs">
                <div>Nom </div>
                <div>Email</div>
                <div>Date</div>
                <div>Actions</div>
            </div>

            <div id="invite-list">
                @foreach($usersInvites as $item)
                <div class="grid grid-cols-4 gap-4 p-2 border-b border-gray-200 invite-item">
                    <div class="px-4 py-2">{{ $item->prenom ?? 'Utilisateur inconnu' }}</div>
                    <div class="px-4 py-2">{{ $item->email ?? 'Email non disponible' }}</div>
                    <div class="px-4 py-2">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                    <div class="px-4 py-2 text-gray-500">
                        <a href="#" class="text-blue-500 underline">Voir</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Contrôles de pagination -->
            <div class="flex justify-center mt-4 space-x-4">
                <button onclick="prevPageInvite()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <span id="page-info-invite" class="px-4 py-2 font-semibold"></span>

                <button onclick="nextPageInvite()" class="px-4 py-2 bg-gray-300 rounded-lg flex items-center">
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
        let itemsPerPageSalon = 4;
        let currentPageSalon = 1;
        let salons = document.querySelectorAll(".salon-item");
        let totalPagesSalon = Math.ceil(salons.length / itemsPerPageSalon);

        function showPageSalon(page) {
            let start = (page - 1) * itemsPerPageSalon;
            let end = start + itemsPerPageSalon;

            salons.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "grid" : "none";
            });

            document.getElementById("page-info-salon").innerText = `Page ${currentPageSalon} / ${totalPagesSalon}`;
        }

        window.nextPageSalon = function () {
            if (currentPageSalon < totalPagesSalon) {
                currentPageSalon++;
                showPageSalon(currentPageSalon);
            }
        };

        window.prevPageSalon = function () {
            if (currentPageSalon > 1) {
                currentPageSalon--;
                showPageSalon(currentPageSalon);
            }
        };

        showPageSalon(currentPageSalon);
    });

    document.addEventListener("DOMContentLoaded", function () {
        let itemsPerPageNotification = 4; // Nombre d'éléments par page
        let currentPageNotification = 1;
        let notifications = document.querySelectorAll(".notification-item");
        let totalPagesNotification = Math.ceil(notifications.length / itemsPerPageNotification);

        function showPageNotification(page) {
            let start = (page - 1) * itemsPerPageNotification;
            let end = start + itemsPerPageNotification;

            notifications.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "grid" : "none";
            });

            document.getElementById("page-info-notification").innerText = `Page ${currentPageNotification} / ${totalPagesNotification}`;
        }

        window.nextPageNotification = function () {
            if (currentPageNotification < totalPagesNotification) {
                currentPageNotification++;
                showPageNotification(currentPageNotification);
            }
        };

        window.prevPageNotification = function () {
            if (currentPageNotification > 1) {
                currentPageNotification--;
                showPageNotification(currentPageNotification);
            }
        };

        showPageNotification(currentPageNotification); // Afficher la première page au chargement
    });

    document.addEventListener("DOMContentLoaded", function () {
        let itemsPerPageEscort = 4;
        let currentPageEscort = 1;
        let escorts = document.querySelectorAll(".escort-item");
        let totalPagesEscort = Math.ceil(escorts.length / itemsPerPageEscort);

        function showPageEscort(page) {
            let start = (page - 1) * itemsPerPageEscort;
            let end = start + itemsPerPageEscort;

            escorts.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "grid" : "none";
            });

            document.getElementById("page-info-escort").innerText = `Page ${currentPageEscort} / ${totalPagesEscort}`;
        }

        window.nextPageEscort = function () {
            if (currentPageEscort < totalPagesEscort) {
                currentPageEscort++;
                showPageEscort(currentPageEscort);
            }
        };

        window.prevPageEscort = function () {
            if (currentPageEscort > 1) {
                currentPageEscort--;
                showPageEscort(currentPageEscort);
            }
        };

        showPageEscort(currentPageEscort);
    });

    document.addEventListener("DOMContentLoaded", function () {
        let itemsPerPageInvite = 4;
        let currentPageInvite = 1;
        let invites = document.querySelectorAll(".invite-item");
        let totalPagesInvite = Math.ceil(invites.length / itemsPerPageInvite);

        function showPageInvite(page) {
            let start = (page - 1) * itemsPerPageInvite;
            let end = start + itemsPerPageInvite;

            invites.forEach((item, index) => {
                item.style.display = index >= start && index < end ? "grid" : "none";
            });

            document.getElementById("page-info-invite").innerText = `Page ${currentPageInvite} / ${totalPagesInvite}`;
        }

        window.nextPageInvite = function () {
            if (currentPageInvite < totalPagesInvite) {
                currentPageInvite++;
                showPageInvite(currentPageInvite);
            }
        };

        window.prevPageInvite = function () {
            if (currentPageInvite > 1) {
                currentPageInvite--;
                showPageInvite(currentPageInvite);
            }
        };

        showPageInvite(currentPageInvite);
    });
</script>
