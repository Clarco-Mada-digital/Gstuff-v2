@extends('layouts.admin')

@section('title', __('users.edit_user'))

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('users.edit_user') }}</h1>
            <a href="{{ route('users.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('users.back') }}
            </a>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6 rounded-lg bg-white p-6 shadow">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="pseudo" class="mb-1 block text-sm font-medium text-gray-700">
                            {{ __('users.pseudo') }} *
                        </label>
                        <input type="text" name="pseudo" id="pseudo" value="{{ old('pseudo', $user->pseudo) }}"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                            required>
                        @error('pseudo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                            {{ __('users.email') }} *
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                            required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium text-gray-700">
                            {{ __('users.new_password') }}
                        </label>
                        <input type="password" name="password" id="password"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                            autocomplete="new-password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">{{ __('users.password_leave_empty') }}</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">
                            {{ __('users.confirm_password') }}
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                            autocomplete="new-password">
                    </div>
                </div>
            </div>

            <div class="mb-6 rounded-lg bg-white p-6 shadow">
                <h2 class="mb-4 text-lg font-medium text-gray-900">{{ __('users.roles') }}</h2>
                <div class="space-y-3">
                    @foreach ($roles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" name="roles[]" id="role-{{ $role->id }}" value="{{ $role->id }}"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label for="role-{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                                <span class="bg-{{ $role->color }}-100 text-{{ $role->color }}-800 rounded-full px-2 py-1 text-xs">
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

            <div class="flex justify-end space-x-3">
                <a href="{{ route('users.index') }}"
                    class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    {{ __('users.cancel') }}
                </a>
                <button type="submit"
                    class="btn-gs-gradient rounded-md px-4 py-2 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> {{ __('users.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
