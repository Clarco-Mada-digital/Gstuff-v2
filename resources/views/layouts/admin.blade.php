@extends('layouts.base')

@section('pageTitle')
    Admin Panel
@endsection

@section('content')
<div x-data="dashboard()">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 pt-20 left-0 z-20 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out"
        :class="{ '-translate-x-full': !sidebarOpen }"
        {{-- @click.away="sidebarOpen = false" --}}
        >
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

        @yield('admin-content')
</div>
    <!-- Main Content -->

@section('extraScripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function dashboard() {
    return {
        searchQuery: '',
        filterStatus: '',
        notifications: [],
        unreadCount: 0,
        sidebarOpen: window.innerWidth >= 768,
        currentPageTitle: 'Tableau de bord',
        user: {
            pseudo: '{{ auth()->user()->pseudo }}',
            email: '{{ auth()->user()->email }}',
            avatar: 'https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->pseudo) }}&background=random'
        },
        menuItems: [
            { label: 'Tableau de bord', route: '{{ route("profile.index") }}', icon: '🏠', badge: null },
            { label: 'Utilisateurs', route: '#', icon: '👥', badge: 'Nouveaux' },
            { label: 'Rôles', route: '{{ route("roles.index") }}', icon: '🔑', badge: null },
            { label: 'Articles', route: '{{ route("articles.index") }}', icon: '📝', badge: null },            
            { label: 'Catégories', route: '#', icon: '🗂️', badge: null },            
            { label: 'Tags', route: '#', icon: '🏷️', badge: null },
            { label: 'Commentaires', route: '#', icon: '💬', badge: '3' },
            { label: 'Paramètres', route: '#', icon: '⚙️', badge: null }, 
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
            // window.Echo.private(`App.Models.User.${this.user.id}`)
            //     .notification((notification) => {
            //         this.notifications.unshift(notification);
            //         this.unreadCount++;
            //     });
        },

        isActive(route) {
            return window.location.pathname === route;
        },

        async fetchStats() {
            try {
                const response = await fetch('/api/admin/api/stats');
                const data = await response.json();
                this.stats = data;
            } catch (error) {
                console.error('Error fetching stats:', error);
            }
        },

        async fetchRecentArticles() {
            try {
                const response = await fetch('/api/admin/api/articles/recent');
                const data = await response.json();
                this.recentArticles = data;
            } catch (error) {
                console.error('Error fetching recent articles:', error);
            }
        },

        async fetchRecentActivity() {
            try {
                const response = await fetch('/api/admin/api/activity');
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
        },

        paginatedItems() {
            return this.items.slice(
                (this.currentPage - 1) * this.perPage,
                this.currentPage * this.perPage
            );
        }
    }
};

</script>
@endsection
@endsection