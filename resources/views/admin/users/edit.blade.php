@extends('layouts.admin')

@section('title', __('users.edit_user'))

@section('admin-content')
    <div class="font-roboto-slab px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-green-gs font-roboto-slab text-2xl font-bold">{{ __('users.edit_user') }}</h1>
            <a href="{{ route('users.index') }}"
                class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('users.back') }}
            </a>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6 rounded-lg bg-white p-6 shadow">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="pseudo" class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">
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
                        <label for="email" class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">
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
                        <label for="password" class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">
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
                        <label for="password_confirmation"
                            class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">
                            {{ __('users.confirm_password') }}
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500"
                            autocomplete="new-password">
                    </div>
                </div>
            </div>

            <div class="mb-6 rounded-lg bg-white p-6 shadow">
                <h2 class="text-green-gs font-roboto-slab mb-4 text-lg font-medium">{{ __('users.roles') }}</h2>
                <div class="space-y-3">
                    @foreach ($roles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" name="roles[]" id="role-{{ $role->id }}"
                                value="{{ $role->id }}"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label for="role-{{ $role->id }}"
                                class="text-green-gs font-roboto-slab ml-3 block text-sm font-medium">
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

            <div class="flex justify-end space-x-3">
                <a href="{{ route('users.index') }}"
                    class="text-green-gs font-roboto-slab focus:ring-green-gs rounded-md bg-gray-200 px-4 py-2 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    {{ __('users.cancel') }}
                </a>
                <button type="submit"
                    class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 focus:ring-green-gs rounded-md px-4 py-2 text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> {{ __('users.save') }}
                </button>
            </div>
        </form>
    </div>
@endsection
