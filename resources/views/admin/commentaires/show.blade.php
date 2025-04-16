@extends('layouts.admin')

@section('pageTitle')
    Commentaires
@endsection

@section('admin-content')
<div x-data="{ selectedTab: 'approved' }" class=" pt-16 min-h-[100vh] container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
           Voir le commentaire
        </h1>
        <a href="{{ route('commentaires.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    <dl class=" bg-white w-full flex justify-around flex-wrap text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700 p-5 m-2 shadow-sm rounded-sm">
       <div class="w-[50%] ">
        <div class="flex flex-col pb-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                <i class="fas fa-user-tag mr-2"></i> Profil type
            </dt>
            <dd class="text-lg font-semibold">{{ $commentaire->user->profile_type }}</dd>
        </div>
        <div class="flex flex-col py-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                <i class="fas fa-comment mr-2"></i> Commentaire
            </dt>
            <dd class="text-lg font-semibold">{{ $commentaire->content }}</dd>
        </div>
        <div class="flex flex-col py-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                <i class="fas fa-user mr-2"></i> Nom
            </dt>
            <dd class="text-lg font-semibold">{{ $commentaire->user->prenom }}</dd>
        </div>
        <div class="flex flex-col pt-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                <i class="fas fa-envelope mr-2"></i> Email
            </dt>
            <dd class="text-lg font-semibold">{{ $commentaire->user->email }}</dd>
        </div>
        <div class="flex flex-col py-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
                <i class="fas fa-map-marker-alt mr-2"></i> Adresse
            </dt>
            <dd class="text-lg font-semibold">{{ $commentaire->user->adresse }}</dd>
        </div>
       </div>
       <div class="w-[45%]  flex justify-center items-center ">
        <div class="w-55 h-55 rounded-full border-5 border-white flex justify-center items-center">
            <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $commentaire->user->avatar }}' ? '{{ asset('storage/avatars/'.$avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })" 
                class="w-full h-full rounded-full object-center object-cover"
                @if($avatar = $commentaire->user->avatar)
                    src="{{ asset('storage/avatars/'.$avatar) }}"
                @else
                    src="{{ asset('images/icon_logo.png') }}"
                @endif
                alt="image profile" />
        </div>
    </div>
    
    </dl>

    <div class="flex justify-end space-x-3">
        <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="return confirm('Êtes-vous sûr de vouloir rejeter ce commentaire ?')">
                <i class="fas fa-times-circle mr-2"></i> Rejeter
            </button>
        </form>

        @if(!$commentaire->is_approved)
            <a href="{{ route('commentaires.approve', $commentaire->id) }}">
                <button type="submit" class="btn-gs-gradient rounded-md px-4 py-2 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-check-circle mr-2"></i> Approuver
                </button>
            </a>
        @endif
    </div>
</div>
@endsection
