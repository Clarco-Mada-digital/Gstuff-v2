@extends('layouts.admin')

@section('title', __('user_management.user_management'))

@section('admin-content')
    <div x-data="userManagement()" class="px-4 sm:px-6 md:py-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('user_management.user_management') }}</h1>
            <a href="{{ route('users.create') }}" class="btn-gs-gradient rounded-md font-bold shadow-md">
                <i class="fas fa-plus mr-2"></i> {{ __('user_management.new_user') }}
            </a>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <h2>{{ __('user_management.profile_verification') }}</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input x-model="searchNotif" type="text" placeholder="{{ __('user_management.search') }}..."
                            class="rounded-lg border py-2 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select x-model="statusFilter"
                        class="w-36 rounded-lg border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">{{ __('user_management.all_statuses') }}</option>
                        <option value="verifier">{{ __('user_management.verified') }}</option>
                        <option value="en cours">{{ __('user_management.in_progress') }}</option>
                        <option value="non verifier">{{ __('user_management.not_verified') }}</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.name') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.email') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.profile') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.profile_type') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.status') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($demandes as $notification)
                            @if ($notification['user'])
                                <tr
                                    x-show="matchesSearchNotification('{{ strtolower($notification['user']->prenom ?? ($notification['user']->nom_salon ?? '')) }}') && matchesStatus('{{ $notification['user']->profile_verifie ?? '' }}') ">
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100">
                                                {{ substr($notification['user']->pseudo ?? ($notification['user']->prenom ?? ($notification['user']->nom_salon ?? '')), 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">
                                                    {{ $notification['user']->pseudo ?? ($notification['user']->prenom ?? ($notification['user']->nom_salon ?? '')) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-gray-500">
                                        {{ $notification['user']->email ?? '' }}</td>

                                    <td class="whitespace-nowrap px-6 py-4 text-gray-500">
                                        @if ($notification['user']->profile_verifie === 'verifier')
                                            <p class="flex items-center rounded-sm p-2 text-xs text-green-500">
                                                <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                                {{ __('user_management.verified') }}
                                            </p>
                                        @elseif($notification['user']->profile_verifie === 'non verifier')
                                            <p class="flex items-center rounded-sm p-2 text-xs text-red-500">
                                                <i class="fas fa-times-circle mr-2 text-red-500"></i>
                                                {{ __('user_management.not_verified') }}
                                            </p>
                                        @elseif($notification['user']->profile_verifie === 'en cours')
                                            <p class="flex items-center rounded-sm p-2 text-xs text-yellow-500">
                                                <i class="fas fa-hourglass-half mr-2 text-yellow-500"></i>
                                                {{ __('user_management.in_progress') }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-gray-500">
                                        {{ $notification['user']->profile_type }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            <p class="text-xs text-gray-400">
                                                {{ __('user_management.sent') }} : {{ $notification['created_at'] }}
                                            </p>
                                            @if ($notification['read_at'])
                                                <p class="text-xs text-green-500">{{ __('user_management.read') }} :
                                                    {{ $notification['read_at'] }}</p>
                                            @else
                                                <p class="text-xs text-red-500">{{ __('user_management.not_read') }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                        <a href="{{ route('users.demande', $notification['user']->id) }}"
                                            class="mr-3 text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form id="delete-form-{{ $notification['user']->id }}"
                                            action="{{ route('notifications.destroy', $notification['user']->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900"
                                                onclick="confirmDelete({{ $notification['user']->id, 'notif' }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @else
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-6 py-4">
                {{ $demandes->links() }}
            </div>
        </div>

        <div class="mt-5 overflow-hidden rounded-lg bg-white shadow">

            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <h2>{{ __('user_management.user_list') }}</h2>
                </div>
                <div class="flex items-center space-x-4">

                    <div class="relative">
                        <input x-model="search" type="text" placeholder="{{ __('user_management.search') }}..."
                            class="rounded-lg border py-2 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select x-model="roleFilter"
                        class="w-36 rounded-lg border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">{{ __('user_management.all_roles') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.name') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.email') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.profile_type') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.roles') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('user_management.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($users as $user)
                            <tr
                                x-show="matchesSearch('{{ strtolower($user->pseudo ?? ($user->prenom ?? $user->nom_salon)) }}') && matchesRole({{ $user->roles->pluck('id') }})">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100">
                                            {{ substr($user->pseudo ?? ($user->prenom ?? $user->nom_salon), 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">
                                                {{ $user->pseudo ?? ($user->prenom ?? $user->nom_salon) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-gray-500">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-gray-500">{{ $user->profile_type }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="bg-{{ $role->color }}-100 text-{{ $role->color }}-800 rounded-full px-2 py-1 text-sm">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 font-medium">
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="mr-3 text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $user->id }}"
                                        action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-900"
                                            onclick="confirmDelete({{ $user->id }}, 'user')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-6 py-4">
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
                },
                matchesSearchNotification(userName) {
                    return userName.includes(this.searchNotif.toLowerCase());
                },
                matchesRole(userRoles) {
                    if (!this.roleFilter) return true;
                    return userRoles.includes(parseInt(this.roleFilter));
                },
                matchesStatus(userStatus) {
                    if (!this.statusFilter || this.statusFilter === "") return true;
                    return userStatus === this.statusFilter;
                }
            }
        }

        function confirmDelete(userId, type) {
            console.log(userId, type);
            Swal.fire({
                title: type === 'user' ? '{{ __("user_management.confirm_delete_user") }}' : '{{ __("user_management.confirm_delete_notification") }}',
                text: '{{ __("user_management.irreversible_action") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("user_management.confirm_delete") }}',
                cancelButtonText: '{{ __("user_management.cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${userId}`).submit();
                }
            });
        }
    </script>
@endsection
