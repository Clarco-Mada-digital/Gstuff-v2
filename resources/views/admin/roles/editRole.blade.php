@extends('layouts.admin')

@section('pageTitle')
    edit
@endsection

@section('admin-content')
    <div class="container mx-auto min-h-[100vh] px-4 py-8 pt-16" x-cloak>



        <h3 class="text-green-gs font-roboto-slab mb-4 text-lg font-medium">Modifier un role</h3>
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf()
            @method('PUT')
            <div class="mb-4">
                <label for="name"
                    class="text-green-gs font-roboto-slab mb-1 block text-sm font-medium">{{ __('role_management.role_name') }}*</label>
                <input type="text" id="name" name="name" required value="{{ $role->name }}"
                    class="focus:border-green-gs focus:ring-green-gs w-full rounded-md border border-gray-300 px-4 py-2">
            </div>

            <div class="mb-4">
                <label
                    class="text-green-gs font-roboto-slab mb-2 block text-sm font-medium">{{ __('role_management.permissions') }}</label>
                <div class="space-y-2">
                    @foreach ($permissions as $permission)
                        <label class="flex items-center">
                            <input type="checkbox" {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                name="permissions[]" value="{{ $permission->name }}"
                                class="text-green-gs focus:ring-green-gs h-4 w-4 rounded border-gray-300">
                            <span
                                class="text-textColorParagraph font-roboto-slab ml-2 text-sm">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('roles.index') }}" type="button"
                    class="text-green-gs hover:bg-green-gs/80 rounded-md border border-gray-300 px-4 py-2 hover:text-white">
                    {{ __('role_management.cancel') }}
                </a>
                <button type="submit" class="bg-green-gs hover:bg-green-gs/80 rounded-md px-4 py-2 text-white">
                    {{ __('role_management.update') }}
                </button>
            </div>
        </form>
    </div>
@endsection
