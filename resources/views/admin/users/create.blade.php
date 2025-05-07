@extends('layouts.admin')

@php
    $create_user = __('create_user.create_user')
@endphp
@section('title_page', $create_user)

@section('admin-content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{__('create_user.create_new_user')}}</h1>
        <a href="{{ route('users.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> {{__('create_user.back')}}
        </a>
    </div>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label for="pseudo" class="block text-sm font-medium text-gray-700 mb-1">{{__('create_user.full_name')}} *</label>
                    <input type="text" name="pseudo" id="pseudo" value="{{ old('pseudo') }}"
                           class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('pseudo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="profile_type" class="block text-sm font-medium text-gray-700 mb-1">{{__('create_user.profile_type')}} *</label>
                    <select name="profile_type" id="profile_type" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="admin">{{__('create_user.admin')}}</option>
                        <option value="escorte">{{__('create_user.escort')}}</option>
                        <option value="salon">{{__('create_user.salon')}}</option>
                        <option value="invite">{{__('create_user.guest')}}</option>
                    </select>
                    @error('profile_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{__('create_user.email')}} *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{__('create_user.birth_date')}} *</label>
                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}"
                           class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('date_naissance')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{__('create_user.password')}} *</label>
                    <input type="password" name="password" id="password"
                           class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{__('create_user.confirm_password')}} *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">{{__('create_user.roles')}}</h2>
            <div class="space-y-3">
                @foreach($roles as $role)
                <div class="flex items-center">
                    <input type="checkbox" name="roles[]" id="role-{{ $role->id }}" value="{{ $role->id }}"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           {{ old('roles') ? (in_array($role->id, old('roles')) ? 'checked' : '') : '' }}>
                    <label for="role-{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                        <span class="px-2 py-1 text-xs rounded-full bg-{{ $role->color }}-100 text-{{ $role->color }}-800">
                            {{ $role->name }}
                        </span>
                        <p class="text-gray-500 text-sm mt-1">{{ $role->description }}</p>
                    </label>
                </div>
                @endforeach
                @error('roles')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{__('create_user.cancel')}}
            </a>
            <button type="submit" class="btn-gs-gradient rounded-md">
                <i class="fas fa-save mr-2"></i> {{__('create_user.save')}}
            </button>
        </div>
    </form>
</div>
@endsection
