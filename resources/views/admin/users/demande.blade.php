@extends('layouts.admin')

@section('title', __('profile_verification.page_title'))

@section('admin-content')
    <div class="font-roboto-slab px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-green-gs font-roboto-slab text-2xl font-bold">{{ __('profile_verification.page_title') }}</h1>
            <a href="{{ route('users.index') }}"
                class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('profile_verification.back') }}
            </a>
        </div>

        <dl
            class="m-2 flex w-full flex-wrap justify-around divide-y divide-gray-200 rounded-sm bg-white p-5 text-gray-900 shadow-sm dark:divide-gray-700 dark:text-white">
            <div class="w-[50%]">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-user-tag mr-2"></i> {{ __('profile_verification.profile_type') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $user->profile_type }}</dd>
                </div>

                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-user mr-2"></i> {{ __('profile_verification.name') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $user->prenom }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-envelope mr-2"></i> {{ __('profile_verification.email') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $user->email }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-map-marker-alt mr-2"></i> {{ __('profile_verification.address') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $user->adresse }}</dd>
                </div>
            </div>
            <div class="flex w-[45%] items-center justify-center">
                <div class="w-55 h-55 border-5 flex items-center justify-center rounded-full border-white">
                    <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $user->image_verification }}' ? '{{ asset('storage/verificationImage/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })"
                        class="h-full w-full rounded-full object-cover object-center"
                        @if ($avatar = $user->image_verification) src="{{ asset('storage/verificationImage/' . $avatar) }}"
                 @else
                     src="{{ asset('images/icon_logo.png') }}" @endif
                        alt="image profile" />
                </div>
            </div>

        </dl>

        <div class="flex justify-end space-x-3">

            @if ($user->profile_verifie !== 'verifier')
                <a href="{{ route('users.approvedProfile', $user->id) }}">
                    <button type="submit"
                        class="bg-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md px-4 py-2 text-white shadow-md">
                        <i class="fas fa-check-circle mr-2"></i> {{ __('profile_verification.actions.approve') }}
                    </button>
                </a>
            @else
                <a href="{{ route('users.notApprovedProfile', $user->id) }}">
                    <button type="submit"
                        class="border-green-gs text-green-gs font-roboto-slab hover:bg-green-gs/80 rounded-md border bg-white px-4 py-2 shadow-md"
                        onclick="return confirm('{{ __('profile_verification.actions.reject_confirm') }}')">
                        <i class="fas fa-times-circle mr-2"></i> {{ __('profile_verification.actions.reject') }}
                    </button>
                </a>
            @endif






        </div>
    </div>
@endsection
