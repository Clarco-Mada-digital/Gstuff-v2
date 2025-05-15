@extends('layouts.admin')

@section('pageTitle')
    {{ __('comments.title') }}
@endsection

@section('admin-content')
    <div x-data="{ selectedTab: 'approved' }" class="container mx-auto min-h-[100vh] px-4 py-8 pt-16">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ __('comments.view_comment') }}
            </h1>
            <a href="{{ route('commentaires.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> {{ __('comments.back') }}
            </a>
        </div>

        <dl
            class="m-2 flex w-full flex-wrap justify-around divide-y divide-gray-200 rounded-sm bg-white p-5 text-gray-900 shadow-sm dark:divide-gray-700 dark:text-white">
            <div class="w-[50%]">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-user-tag mr-2"></i> {{ __('comments.profile_type') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $commentaire->user->profile_type }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-comment mr-2"></i> {{ __('comments.comment') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $commentaire->content }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-user mr-2"></i> {{ __('comments.name') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $commentaire->user->prenom }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-envelope mr-2"></i> {{ __('comments.email') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $commentaire->user->email }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-map-marker-alt mr-2"></i> {{ __('comments.address') }}
                    </dt>
                    <dd class="text-lg font-semibold">{{ $commentaire->user->adresse }}</dd>
                </div>
            </div>
            <div class="flex w-[45%] items-center justify-center">
                <div class="w-55 h-55 border-5 flex items-center justify-center rounded-full border-white">
                    <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $commentaire->user->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })"
                        class="h-full w-full rounded-full object-cover object-center"
                        @if ($avatar = $commentaire->user->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                @else
                    src="{{ asset('images/icon_logo.png') }}" @endif
                        alt="image profile" />
                </div>
            </div>

        </dl>

        <div class="flex justify-end space-x-3">
            <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    onclick="return confirm('{{ __('comments.confirm_reject') }}')">
                    <i class="fas fa-times-circle mr-2"></i> {{ __('comments.reject') }}
                </button>
            </form>

            @if (!$commentaire->is_approved)
                <a href="{{ route('commentaires.approve', $commentaire->id) }}">
                    <button type="submit"
                        class="btn-gs-gradient rounded-md px-4 py-2 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-check-circle mr-2"></i> {{ __('comments.approve') }}
                    </button>
                </a>
            @endif
        </div>
    </div>
@endsection
