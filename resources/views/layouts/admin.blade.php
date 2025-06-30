@extends('layouts.base')

@section('pageTitle')
    {{ __('admin_panel.admin_panel') }}
@endsection

@section('content')
    <div x-data="dashboard()">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-20 w-64 transform bg-white pt-20 shadow-lg transition-transform duration-300 ease-in-out"
            :class="{ '-translate-x-full': !sidebarOpen }" {{-- @click.away="sidebarOpen = false" --}}>
            <div class="flex h-16 items-center justify-center bg-blue-600 px-4 text-white">
                <span class="text-xl font-bold">{{ __('admin_panel.admin_panel') }}</span>
            </div>
            <nav class="mt-6">
                <template x-for="(item, index) in menuItems" :key="index">
                    <a :href="item.route"
                        class="flex items-center px-6 py-3 text-gray-600 hover:bg-blue-50 hover:text-blue-600"
                        :class="{ 'bg-blue-50 text-blue-600 border-r-4 border-blue-600': isActive(item.route) }">
                        <span x-text="item.icon" class="mr-3"></span>
                        <span x-text="item.label"></span>
                        <template x-if="item.badge">
                            <span class="ml-auto rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800"
                                x-text="item.badge"></span>
                        </template>
                    </a>
                </template>
            </nav>
        </div>

        <div class="min-h-[80vh] bg-gray-100 md:ml-64">
            @yield('admin-content')
        </div>

    </div>
    <!-- Main Content -->

@section('extraScripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function dashboard() {
            return {
                currentPage: 1,
                perPage: 5,
                searchQuery: '',
                filterStatus: '',
                activityFilter: '',
                notifications: [],
                unreadCount: 0,
                sidebarOpen: window.innerWidth >= 768,
                currentPageTitle: '{{ __('admin_panel.dashboard') }}',
                sort: {
                    field: 'created_at',
                    direction: 'desc'
                },
                filters: {
                    status: '',
                    search: ''
                },
                user: {
                    pseudo: '{{ auth()->user()->pseudo }}',
                    email: '{{ auth()->user()->email }}',
                    avatar: 'https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->pseudo) }}&background=random'
                },
                menuItems: [{
                        label: '{{ __('admin_panel.dashboard') }}',
                        route: '{{ route('profile.index') }}',
                        icon: '🏠',
                        badge: null
                    },
                    {
                        label: '{{ __('admin_panel.users') }}',
                        route: '{{ route('users.index') }}',
                        icon: '👥',
                        badge: null
                    },
                    {
                        label: '{{ __('admin_panel.roles_permissions') }}',
                        route: '{{ route('roles.index') }}',
                        icon: '🔑',
                        badge: null
                    },
                    {
                        label: '{{ __('admin_panel.articles') }}',
                        route: '{{ route('articles.admin') }}',
                        icon: '📝',
                        badge: null
                    },
                    {
                        label: '{{ __('admin_panel.pages') }}',
                        route: '{{ route('static.index') }}',
                        icon: '📄',
                        badge: null
                    },
                    {
                        label: '{{ __('admin_panel.categories_tags') }}',
                        route: '{{ route('taxonomy') }}',
                        icon: '🗂️',
                        badge: null
                    },
                    {
                        label: '{{ __('admin_panel.comments') }}',
                        route: '{{ route('commentaires.index') }}',
                        icon: '💬',
                        badge: null
                    },
                    {
                        label: '{{ __('admin_panel.settings') }}',
                        route: '#',
                        icon: '⚙️',
                        badge: null
                    },
                ],
                recentActivity: [],
                stats: {
                    articles: 0,
                    users: 0,
                    comments: 0,
                    views: 0,
                    escorteApproved: 0,
                    distanceMax: 0
                },
                userSatats: [],
                recentArticles: [],
                chart: null,

                // Fonction de filtrage
                filteredArticles() {
                    return this.recentArticles.filter(article => {
                        // Filtre par statut
                        let statusMatch = true;
                        if (this.filters.status === 'published') {
                            statusMatch = article.is_published;
                        } else if (this.filters.status === 'unpublished') {
                            statusMatch = !article.is_published;
                        }

                        // Filtre par recherche
                        const searchMatch = this.filters.search === '' ||
                            article.title.toLowerCase().includes(this.filters.search.toLowerCase()) ||
                            article.excerpt.toLowerCase().includes(this.filters.search.toLowerCase());

                        console.log(article.title);

                        return statusMatch && searchMatch;
                    });
                },

                // Réinitialisation des filtres
                resetFilters() {
                    this.filters = {
                        status: '',
                        search: ''
                    };
                },
                // Méthode de tri
                sortedArticles() {
                    return [...this.filteredArticles()].sort((a, b) => {
                        let modifier = 1;
                        if (this.sort.direction === 'desc') modifier = -1;

                        if (a[this.sort.field] < b[this.sort.field]) return -1 * modifier;
                        if (a[this.sort.field] > b[this.sort.field]) return 1 * modifier;
                        return 0;
                    });
                },
                getActivityIcon(type) {
                    const icons = {
                        'Article': '📝',
                        'User': '👤',
                        'Settings': '⚙️',
                        'System': '🖥️'
                    };
                    const prefix = type.split("\\")[2];
                    return icons[prefix] || '🔔';
                },

                init() {
                    this.fetchStats();
                    this.fetchRecentArticles();
                    this.fetchRecentActivity();
                    this.fetchUnreadCommentsCount();
                    this.fetchNewUsersCount();

                    // Restaurer les filtres depuis localStorage si disponible
                    if (localStorage.getItem('dashboardFilters')) {
                        this.filters = JSON.parse(localStorage.getItem('dashboardFilters'));
                    }

                    // Sauvegarder les filtres lorsqu'ils changent
                    this.$watch('filters', (value) => {
                        localStorage.setItem('dashboardFilters', JSON.stringify(value));
                    }, {
                        deep: true
                    });

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
                    return route.includes(window.location.href);
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

                async fetchUserStats() {
                    try {
                        const response = await fetch('/api/admin/api/user-stats');
                        const data = await response.json();
                        this.userSatats = data;
                        this.initChart();

                    } catch (error) {
                        console.error('Error fetching user stats:', error);
                    }
                },

                async fetchRecentArticles() {
                    try {
                        const response = await fetch('/api/admin/api/articles/recent');
                        const data = await response.json();
                        this.recentArticles = data;
                        console.log(this.recentArticles);
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

                async fetchUnreadCommentsCount() {
                    try {
                        const response = await fetch('/admin/unread-comments');
                        const data = await response.json();
                       

                        this.updateMenuItemBadge('{{ __('admin_panel.comments') }}', data.count);
                    } catch (error) {
                        console.error('Error fetching unread comments count:', error);
                    }
                },

                async fetchNewUsersCount() {
                    try {
                        const response = await fetch('/admin/new-users-count');
                        const data = await response.json();
                        this.updateMenuItemBadge('{{ __('admin_panel.users') }}', data.count);
                    } catch (error) {
                        console.error('Error fetching new users count:', error);
                    }
                },

                updateMenuItemBadge(label, count) {
                    const menuItem = this.menuItems.find(item => item.label === label);
                    if (menuItem) {
                        menuItem.badge = count > 0 ? count.toString() : null;
                    }
                },

                async initChart() {
                    const response = await fetch('/api/admin/api/user-stats');

                    function getRandomColor() {
                        const r = Math.floor(Math.random() * 256);
                        const g = Math.floor(Math.random() * 256);
                        const b = Math.floor(Math.random() * 256);
                        return `rgb(${r},${g},${b})`;
                    }
                    const data = await response.json();
                    this.userSatats = data;

                    const ctx = this.$refs.chartCanvas.getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: this.userSatats.labels,
                            datasets: Object.keys(this.userSatats.datasets).map(type => ({
                                label: type,
                                data: this.userSatats.datasets[type],
                                backgroundColor: getRandomColor(),
                                tension: 0.4,
                                fill: true
                            }))
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
                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    };
                    return new Date(dateString).toLocaleDateString('fr-FR', options);
                },

                formatTimeAgo(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const seconds = Math.floor((now - date) / 1000);

                    if (seconds < 60) return "{{ __('admin_panel.just_now') }}";

                    const minutes = Math.floor(seconds / 60);
                    if (minutes < 60) return ` ${minutes} min`;

                    const hours = Math.floor(minutes / 60);
                    if (hours < 24) return ` ${hours} h`;

                    const days = Math.floor(hours / 24);
                    if (days < 7) return `${days} j`;

                    return this.formatDate(dateString);
                },



                // Méthode paginée
                paginatedArticles() {
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    return this.filteredArticles().slice(start, end);
                },
                // Nombre total de pages
                totalPages() {
                    return Math.ceil(this.filteredArticles().length / this.perPage);
                },
            }
        };

        function roleForm() {
            return {
                openModal: false,
                form: {
                    name: '',
                    permissions: []
                },
                errors: {}, // Ajoutez ceci pour gérer les erreurs

                submitForm() {
                    // Formatage pour Laravel
                    const formData = {
                        name: this.form.name,
                        permissions: this.form.permissions.map(Number) // Conversion en integers si nécessaire
                    };

                    fetch("{{ route('roles.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(formData)
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw err;
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            window.location.reload();
                        })
                        .catch(error => {
                            if (error.errors) {
                                this.errors = error.errors; // Affichage des erreurs
                            }
                            console.error('Error:', error);
                        });
                }
            }
        }
    </script>
@endsection
@endsection
