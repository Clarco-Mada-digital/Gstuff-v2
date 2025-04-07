@extends('layouts.admin')

@section('pageTitle')
Commentaires
@endsection

@section('admin-content')
<div x-data="{ selectedTab: 'approved' }" class="md:ml-64 pt-16 min-h-[100vh] container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Voir le commentaire</h1>
        <a href="{{ route('commentaires.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
        <div class="flex flex-col pb-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Profil type</dt>
            <dd class="text-lg font-semibold">{{ $commentaire->user->profile_type }}</dd>
        </div>
        <div class="flex flex-col py-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Commentaire</dt>
            <dd class="text-lg font-semibold">{{ $commentaire->content }}</dd>
        </div>
        <div class="flex flex-col py-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Nom</dt>
            <dd class="text-lg font-semibold">{{ $commentaire->user->prenom }}</dd>
        </div>
        <div class="flex flex-col pt-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Email</dt>
            <dd class="text-lg font-semibold"> {{ $commentaire->user->email }}</dd>
        </div>
        <div class="flex flex-col py-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Adresse</dt>
            <dd class="text-lg font-semibold">{{ $commentaire->user->adresse }}</dd>
        </div>
        <div class="flex flex-col pt-3">
            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Email</dt>
            <dd class="text-lg font-semibold"> {{ $commentaire->user->email }}</dd>
        </div>
    </dl>
    <div class="flex justify-end space-x-3">

        <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="return confirm('Êtes-vous sûr de vouloir rejeter cet Commentaire ?')">
                Rejeter
            </button>
        </form>

        <a 
        href="{{ route('commentaires.approve', $commentaire->id) }}"
        >
         <button type="submit" class="btn-gs-gradient rounded-md px-4 py-2 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-save mr-2"></i> Approuver
        </button>
        </a>
       
    </div>
</div>
@endsection
