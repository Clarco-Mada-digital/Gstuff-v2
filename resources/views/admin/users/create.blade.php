@extends('layouts.admin')

@php
    $create_user = __('create_user.create_user');
@endphp
@section('title_page', $create_user)

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8 font-roboto-slab">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-green-gs font-roboto-slab">{{ __('create_user.create_new_user') }}</h1>
            <a href="{{ route('users.index') }}" class="bg-green-gs text-white px-4 py-2 font-roboto-slab hover:bg-green-gs/80 
            rounded-md  shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('create_user.back') }}
            </a>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-6 rounded-lg bg-white p-6 shadow">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    <div>
                        <label for="pseudo"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_user.full_name') }} *</label>
                        <input type="text" name="pseudo" id="pseudo" value="{{ old('pseudo') }}"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-green-gs focus:outline-none focus:ring-green-gs"
                            required>
                        @error('pseudo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="profile_type"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_user.profile_type') }}
                            *</label>
                        <select name="profile_type" id="profile_type"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-green-gs focus:outline-none focus:ring-green-gs">
                            <option value="admin">{{ __('create_user.admin') }}</option>
                            <option value="escorte">{{ __('create_user.escort') }}</option>
                            <option value="salon">{{ __('create_user.salon') }}</option>
                            <option value="invite">{{ __('create_user.guest') }}</option>
                        </select>
                        @error('profile_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_user.email') }} *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-green-gs focus:outline-none focus:ring-green-gs"
                            required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_user.birth_date') }}
                            *</label>
                        <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-green-gs focus:outline-none focus:ring-green-gs"
                            required>
                        @error('date_naissance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="password"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_user.password') }} *</label>
                        <input type="password" name="password" id="password"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-green-gs focus:outline-none focus:ring-green-gs"
                            required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="password_confirmation"
                            class="mb-1 block text-sm font-medium text-green-gs font-roboto-slab">{{ __('create_user.confirm_password') }}
                            *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-green-gs focus:outline-none focus:ring-green-gs"
                            required>
                    </div>
                </div>
            </div>

            <div class="mb-6 rounded-lg bg-white p-6 shadow">
                <h2 class="mb-4 text-lg font-medium text-green-gs font-roboto-slab">{{ __('create_user.roles') }}</h2>
                <div class="space-y-3">
                    @foreach ($roles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" name="roles[]" id="role-{{ $role->id }}"
                                value="{{ $role->id }}"
                                class="h-4 w-4 rounded border-gray-300 text-green-gs focus:ring-green-gs"
                                {{ old('roles') ? (in_array($role->id, old('roles')) ? 'checked' : '') : '' }}>
                            <label for="role-{{ $role->id }}" class="ml-3 block text-sm font-medium text-green-gs font-roboto-slab">
                                <span
                                    class="bg-{{ $role->color }}-100 text-{{ $role->color }}-800 rounded-full px-2 py-1 text-xs">
                                    {{ $role->name }}
                                </span>
                                <p class="mt-1 text-sm text-gray-500">{{ $role->description }}</p>
                            </label>
                        </div>
                    @endforeach
                    @error('roles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('users.index') }}"
                    class="rounded-md bg-white border border-green-gs px-4 py-2 text-green-gs font-roboto-slab hover:bg-green-gs/80  hover:text-white
            rounded-md  shadow-md">
                    {{ __('create_user.cancel') }}
                </a>
                <button type="submit" class="rounded-md bg-green-gs px-4 py-2 text-white font-roboto-slab hover:bg-green-gs/80 
            rounded-md  shadow-md">
                    <i class="fas fa-save mr-2"></i> {{ __('create_user.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
