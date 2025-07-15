@extends('layouts.admin')

@section('pageTitle')
    {{ __('role_management.role') }}
@endsection

@section('admin-content')
    <div x-data="roleForm()" class="container mx-auto min-h-[100vh] px-4 py-8 pt-16" x-cloak>
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('role_management.role_management') }}</h1>
            <button @click="openModal = true" class="rounded bg-green-gs px-4 py-2 text-white font-roboto-slab hover:bg-green-gs/80 
            rounded-md  shadow-md">
                {{ __('role_management.create_role') }}
            </button>
        </div>

        <!-- Tableau des rôles -->
        <div class="overflow-hidden rounded-lg bg-white shadow font-roboto-slab">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            {{ __('role_management.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            {{ __('role_management.permissions') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                            {{ __('role_management.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($roles as $role)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    class="bg-{{ $role->name === 'admin' ? 'purple' : 'blue' }}-100 text-{{ $role->name === 'admin' ? 'purple' : 'blue' }}-800 inline-flex rounded-full px-2 text-xs font-semibold leading-5">
                                    {{ $role->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($role->permissions as $permission)
                                        <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-800">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            <a href="{{ route('roles.edit', $role->id) }}" class="mr-3 text-green-gs hover:text-white hover:bg-green-gs/80">
                                {{ __('role_management.edit') }}
                            </a>

                                @if ($role->name !== 'admin')
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900">{{ __('role_management.delete') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modale de création -->
        <div x-show="openModal" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="openModal = false" class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                <h3 class="mb-4 text-lg font-medium text-green-gs font-roboto-slab">{{ __('role_management.create_new_role') }}</h3>

                <form @submit.prevent="submitForm">
                    @csrf()
                    <div class="mb-4">
                        <label for="name"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('role_management.role_name') }}*</label>
                        <input type="text" id="name" x-model="form.name" required
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-green-gs focus:ring-green-gs">
                    </div>

                    <div class="mb-4">
                        <label
                            class="mb-2 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('role_management.permissions') }}</label>
                        <div class="space-y-2">
                            @foreach ($permissions as $permission)
                                <label class="flex items-center">
                                    <input type="checkbox" x-model="form.permissions" value="{{ $permission->id }}"
                                        class="h-4 w-4 rounded border-gray-300 text-green-gs focus:ring-green-gs">
                                    <span class="ml-2 text-sm text-textColorParagraph font-roboto-slab">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="openModal = false"
                            class="rounded-md border border-gray-300 px-4 py-2 text-green-gs hover:text-white hover:bg-green-gs/80">
                            {{ __('role_management.cancel') }}
                        </button>
                        <button type="submit" class="rounded-md bg-green-gs text-white px-4 py-2 hover:bg-green-gs/80">
                            {{ __('role_management.create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
