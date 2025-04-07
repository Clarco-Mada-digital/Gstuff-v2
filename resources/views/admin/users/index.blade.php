
@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('admin-content')
<div x-data="userManagement()" class="md:ml-64 py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestion des utilisateurs</h1>
        <a href="{{ route('users.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Nouvel utilisateur
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input x-model="search" type="text" placeholder="Rechercher..." 
                           class="pl-10 pr-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <select x-model="roleFilter" class="border rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
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
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
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

<script>
function userManagement() {
    return {
        search: '',
        roleFilter: '',
        
        matchesSearch(userName) {
            return userName.includes(this.search.toLowerCase());
        },
        
        matchesRole(userRoles) {
            if (!this.roleFilter) return true;
            return userRoles.includes(parseInt(this.roleFilter));
        }
    }
}
</script>
@endsection