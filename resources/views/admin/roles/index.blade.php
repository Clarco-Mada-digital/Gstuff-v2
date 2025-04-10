@extends('layouts.admin')

@section('pageTitle')
    Role
@endsection

@section('admin-content')
<div x-data="roleForm()" class="pt-16 min-h-[100vh] container mx-auto px-4 py-8" x-cloak>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des rôles</h1>
        <button @click="openModal = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Créer un rôle
        </button>
    </div>

    <!-- Tableau des rôles -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Permissions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($roles as $role)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    bg-{{ $role->name === 'admin' ? 'purple' : 'blue' }}-100 text-{{ $role->name === 'admin' ? 'purple' : 'blue' }}-800">
                            {{ $role->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($role->permissions as $permission)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                {{ $permission->name }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900 mr-3">Éditer</a>
                        @if($role->name !== 'admin')
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modale de création -->
    <div x-show="openModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="openModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Créer un nouveau rôle</h3>
            
            <form @submit.prevent="submitForm">
                @csrf()
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom du rôle*</label>
                    <input type="text" id="name" x-model="form.name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                    <div class="space-y-2">
                        @foreach($permissions as $permission)
                        <label class="flex items-center">
                            <input type="checkbox" x-model="form.permissions" value="{{ $permission->id }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="openModal = false"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection