@extends('layouts.admin')

@section('content')
<div x-data="dashboard()" class="min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out"
         :class="{ '-translate-x-full': !sidebarOpen }"
         @click.away="sidebarOpen = false">
        <div class="flex items-center justify-center h-16 px-4 bg-blue-600 text-white">
            <span class="text-xl font-bold">Admin Panel</span>
        </div>
        <nav class="mt-6">
            <template x-for="(item, index) in menuItems" :key="index">
                <a :href="item.route" 
                   class="flex items-center px-6 py-3 text-gray-600 hover:bg-blue-50 hover:text-blue-600"
                   :class="{ 'bg-blue-50 text-blue-600 border-r-4 border-blue-600': isActive(item.route) }">
                    <span x-text="item.icon" class="mr-3"></span>
                    <span x-text="item.label"></span>
                    <template x-if="item.badge">
                        <span class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full" 
                              x-text="item.badge"></span>
                    </template>
                </a>
            </template>
        </nav>
    </div>

    <!-- Mobile header -->
    <div class="fixed inset-x-0 top-0 z-40 bg-white shadow-sm md:hidden">
        <div class="flex items-center justify-between h-16 px-4">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="text-lg font-semibold text-gray-800">Dashboard</div>
            <div class="w-6"></div> <!-- Spacer -->
        </div>
    </div>

    <!-- Main content -->
    <div class="md:ml-64 pt-16">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-900" x-text="currentPageTitle"></h1>
                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-gray-600" x-text="user.name"></span>
                            <img class="h-8 w-8 rounded-full" :src="user.avatar" alt="User profile">
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Stats Cards -->
            <div class="flex items-center space-x-4 mb-4">
              <select x-model="filterStatus" class="border-gray-300 rounded-md shadow-sm">
                  <option value="">Tous les statuts</option>
                  <option value="published">Publié</option>
                  <option value="draft">Brouillon</option>
              </select>
              <input type="text" x-model="searchQuery" placeholder="Rechercher..." class="border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Articles</p>
                            <p class="text-2xl font-semibold" x-text="stats.articles"></p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('articles.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tous →</a>
                    </div>
                </div>
                
                <!-- Ajoutez d'autres cartes de statistiques ici -->
            </div>

            <!-- Derniers articles -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Derniers articles</h2>
                    <a href="{{ route('articles.create') }}" class="text-sm text-blue-600 hover:text-blue-800">+ Nouvel article</a>
                </div>
                <div class="divide-y divide-gray-200">
                    <template x-for="article in recentArticles" :key="article.id">
                        <div class="px-6 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <a :href="`/admin/articles/${article.id}/edit`" class="font-medium text-gray-900 hover:text-blue-600" x-text="article.title"></a>
                                    <p class="text-sm text-gray-500 mt-1" x-text="article.excerpt"></p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs rounded-full" 
                                          :class="{
                                            'bg-green-100 text-green-800': article.status === 'published',
                                            'bg-yellow-100 text-yellow-800': article.status === 'draft',
                                            'bg-gray-100 text-gray-800': article.status === 'archived'
                                          }"
                                          x-text="article.status"></span>
                                    <span class="text-sm text-gray-500" x-text="formatDate(article.created_at)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Activité récente -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Activité récente</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <template x-for="activity in recentActivity" :key="activity.id">
                            <div class="px-6 py-4">
                                <div class="flex items-start">
                                    <img class="h-10 w-10 rounded-full mr-3" :src="activity.user.avatar" :alt="activity.user.name">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900" x-text="activity.user.name"></p>
                                        <p class="text-sm text-gray-500" x-text="activity.description"></p>
                                        <p class="text-xs text-gray-400 mt-1" x-text="formatTimeAgo(activity.created_at)"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Statistiques</h2>
                    </div>
                    <div class="p-6">
                        <canvas id="statsChart" x-ref="chartCanvas" height="250"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
 
{{-- rest menu
// { label: 'Tags', route: '{{ route("tags.index") }}', icon: '🏷️', badge: null },
// { label: 'Utilisateurs', route: '{{ route("users.index") }}', icon: '👥', badge: null },
// { label: 'Commentaires', route: '{{ route("comments.index") }}', icon: '💬', badge: '3' },
// { label: 'Paramètres', route: '{{ route("settings") }}', icon: '⚙️', badge: null }, 
{ label: 'Catégories', route: '{{ route("categories.index") }}', icon: '🗂️', badge: null },
--}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function dashboard() {
    return {
        notifications: [],
        unreadCount: 0,
        sidebarOpen: window.innerWidth >= 768,
        currentPageTitle: 'Tableau de bord',
        user: {
            name: '{{ auth()->user()->name }}',
            email: '{{ auth()->user()->email }}',
            avatar: 'https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random'
        },
        menuItems: [
            { label: 'Tableau de bord', route: '{{ route("profile.index") }}', icon: '🏠', badge: null },
            { label: 'Articles', route: '{{ route("articles.index") }}', icon: '📝', badge: null },            
            { label: 'Rôles', route: '{{ route("roles.index") }}', icon: '🔑', badge: null },            
        ],
        stats: {
            articles: 0,
            users: 0,
            comments: 0,
            views: 0
        },
        recentArticles: [],
        recentActivity: [],
        chart: null,

        init() {
            this.fetchStats();
            this.fetchRecentArticles();
            this.fetchRecentActivity();
            
            // Initialiser le graphique après le rendu
            this.$nextTick(() => {
                this.initChart();
            });

            // Gestion du redimensionnement
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    this.sidebarOpen = true;
                }
            });

            // Écouter les nouvelles notifications
            window.Echo.private(`App.Models.User.${this.user.id}`)
                .notification((notification) => {
                    this.notifications.unshift(notification);
                    this.unreadCount++;
                });
        },

        isActive(route) {
            return window.location.pathname === route;
        },

        async fetchStats() {
            try {
                const response = await fetch('/admin/api/stats');
                const data = await response.json();
                this.stats = data;
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        },

        async fetchRecentArticles() {
            try {
                const response = await fetch('/admin/api/articles/recent');
                const data = await response.json();
                this.recentArticles = data;
            } catch (error) {
                console.error('Error fetching recent articles:', error);
            }
        },

        async fetchRecentActivity() {
            try {
                const response = await fetch('/admin/api/activity');
                const data = await response.json();
                this.recentActivity = data;
            } catch (error) {
                console.error('Error fetching recent activity:', error);
            }
        },

        initChart() {
            const ctx = this.$refs.chartCanvas.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Visiteurs',
                        data: [65, 59, 80, 81, 56, 72],
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Articles',
                        data: [28, 48, 40, 19, 86, 27],
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },

        formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('fr-FR', options);
        },

        formatTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            
            if (seconds < 60) return 'à l\'instant';
            
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `il y a ${minutes} min`;
            
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `il y a ${hours} h`;
            
            const days = Math.floor(hours / 24);
            if (days < 7) return `il y a ${days} j`;
            
            return this.formatDate(dateString);
        }
    }
}

paginatedItems() {
    return this.items.slice(
        (this.currentPage - 1) * this.perPage,
        this.currentPage * this.perPage
    );
}
</script>
@endpush
@endsection