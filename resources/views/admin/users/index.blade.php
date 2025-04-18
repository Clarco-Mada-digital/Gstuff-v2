@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('admin-content')
<div x-data="userManagement()" class="md:py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestion des utilisateurs</h1>
        <a href="{{ route('users.create') }}" class="btn-gs-gradient rounded-md shadow-md font-bold">
            <i class="fas fa-plus mr-2"></i> Nouvel utilisateur
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2>Vérification des profils</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input x-model="searchNotif" type="text" placeholder="Rechercher..." 
                    class="pl-10 text-sm pr-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select x-model="statusFilter" class="border text-sm rounded-lg px-3 py-2 w-36 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les status</option>
                    <option value="verifier">Vérifier</option>
                    <option value="en cours">En cours</option>
                    <option value="non verifier">Non vérifier</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($demandes as $notification)
                    <tr x-show="matchesSearchNotification('{{ strtolower($notification['user']->prenom ?? $notification['user']->nom_salon) }}') && matchesStatus('{{ $notification['user']->profile_verifie }}') ">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    {{ substr($notification['user']->pseudo ?? $notification['user']->prenom ?? $notification['user']->nom_salon, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">{{ $notification['user']->pseudo ?? $notification['user']->prenom ?? $notification['user']->nom_salon }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $notification['user']->email }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            @if($notification['user']->profile_verifie === 'verifier')
                            <p class="text-xs text-green-500 p-2 rounded-sm flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i> Vérifié
                            </p>
                            @elseif($notification['user']->profile_verifie === 'non verifier')
                            <p class="text-xs text-red-500 p-2 rounded-sm flex items-center">
                                <i class="fas fa-times-circle text-red-500 mr-2"></i> Non Vérifié
                            </p>
                            @elseif($notification['user']->profile_verifie === 'en cours')
                            <p class="text-xs  p-2 rounded-sm flex items-center text-yellow-500">
                                <i class="fas fa-hourglass-half text-yellow-500 mr-2"></i> En cours
                            </p>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $notification['user']->profile_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                <p class="text-xs text-gray-400">
                                    Envoyé : {{ $notification['created_at'] }}
                                </p>
                                @if ($notification['read_at'])
                                <p class="text-xs text-green-500">Lu : {{ $notification['read_at'] }}</p>
                                @else
                                <p class="text-xs text-red-500">Non lu</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                            <a href="{{route('users.demande', $notification['user']->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form id="delete-form-{{  $notification['user']->id }}" action="{{ route('notifications.destroy',  $notification['user']->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-900" onclick="confirmDelete({{  $notification['user']->id , 'notif' }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $demandes->links() }}
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden mt-5">

        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2>Liste des utilisateurs</h2>
            </div>
            <div class="flex items-center space-x-4">

                <div class="relative">
                    <input x-model="search" type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select x-model="roleFilter" class="border rounded-lg px-3 py-2 w-36 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les rôles</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôles</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr x-show="matchesSearch('{{ strtolower($user->pseudo ?? $user->prenom ?? $user->nom_salon) }}') && matchesRole({{ $user->roles->pluck('id') }})">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    {{ substr($user->pseudo ?? $user->prenom ?? $user->nom_salon, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">{{ $user->pseudo ?? $user->prenom ?? $user->nom_salon }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $user->profile_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-sm rounded-full 
                                      bg-{{ $role->color }}-100 text-{{ $role->color }}-800">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-900" onclick="confirmDelete({{ $user->id , 'user' }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function userManagement() {
        return {
            search: '',
            searchNotif: '',
            roleFilter: '',
            statusFilter: '',

            matchesSearch(userName) {
                return userName.includes(this.search.toLowerCase());
            }
            , matchesSearchNotification(userName) {
                return userName.includes(this.searchNotif.toLowerCase());
            },

            matchesRole(userRoles) {
                
                if (!this.roleFilter) return true;
                return userRoles.includes(parseInt(this.roleFilter));
            }
            , matchesStatus(userStatus) {
                if (!this.statusFilter || this.statusFilter === "") return true; 
                return userStatus === this.statusFilter; 
            }

        }
    }

    function confirmDelete(userId, type) {
        Swal.fire({
            title: type === 'user' ? ' Êtes-vous sûr de vouloir supprimer cet utilisateur ?' : ' Êtes-vous sûr de vouloir supprimer cette demande ?'
            , text: "Cette action est irréversible !"
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Oui, supprimer'
            , cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${userId}`).submit();
            }
        });
    }

</script>
@endsection
