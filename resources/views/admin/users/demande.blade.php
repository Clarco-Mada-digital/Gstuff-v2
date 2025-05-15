@extends('layouts.admin')

@section('title', 'Voir le demande')

@section('admin-content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Voire le demande de l'utilisateur</h1>
            <a href="{{ route('users.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>

        <dl
            class="m-2 flex w-full flex-wrap justify-around divide-y divide-gray-200 rounded-sm bg-white p-5 text-gray-900 shadow-sm dark:divide-gray-700 dark:text-white">
            <div class="w-[50%]">
                <div class="flex flex-col pb-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-user-tag mr-2"></i> Profil type
                    </dt>
                    <dd class="text-lg font-semibold">{{ $user->profile_type }}</dd>
                </div>

                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-user mr-2"></i> Nom
                    </dt>
                    <dd class="text-lg font-semibold">{{ $user->prenom }}</dd>
                </div>
                <div class="flex flex-col pt-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-envelope mr-2"></i> Email
                    </dt>
                    <dd class="text-lg font-semibold">{{ $user->email }}</dd>
                </div>
                <div class="flex flex-col py-3">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                        <i class="fas fa-map-marker-alt mr-2"></i> Adresse
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
                        class="btn-gs-gradient rounded-md px-4 py-2 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-check-circle mr-2"></i> Approuver
                    </button>
                </a>
            @else
                <a href="{{ route('users.notApprovedProfile', $user->id) }}">
                    <button type="submit"
                        class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        onclick="return confirm('Êtes-vous sûr de vouloir rejeter ce demande ?')">
                        <i class="fas fa-times-circle mr-2"></i> Rejeter
                    </button>
                </a>
            @endif






        </div>
    </div>
@endsection
