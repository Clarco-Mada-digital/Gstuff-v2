@extends('layouts.admin')

@section('title', 'Voir le demande')

@section('admin-content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Voire le demande de l'utilisateur</h1>
        <a href="{{ route('users.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>

    <dl class=" bg-white w-full flex justify-around flex-wrap text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700 p-5 m-2 shadow-sm rounded-sm">
        <div class="w-[50%] ">
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
        <div class="w-[45%]  flex justify-center items-center ">
         <div class="w-55 h-55 rounded-full border-5 border-white flex justify-center items-center">
             <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $user->image_verification }}' ? '{{ asset('storage/verificationImage/'.$avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })" 
                 class="w-full h-full rounded-full object-center object-cover"
                 @if($avatar = $user->image_verification)
                     src="{{ asset('storage/verificationImage/'.$avatar) }}"
                 @else
                     src="{{ asset('images/icon_logo.png') }}"
                 @endif
                 alt="image profile" />
         </div>
     </div>
     
     </dl>
 
     <div class="flex justify-end space-x-3">

        @if($user->profile_verifie !== 'verifier')
        <a href="{{ route('users.approvedProfile', $user->id) }}">
            <button type="submit" class="btn-gs-gradient rounded-md px-4 py-2 font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-check-circle mr-2"></i> Approuver
            </button>
        </a>
        @else

        <a href="{{ route('users.notApprovedProfile', $user->id) }}">
            <button type="submit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="return confirm('Êtes-vous sûr de vouloir rejeter ce demande ?')">
                <i class="fas fa-times-circle mr-2"></i> Rejeter
            </button>
        </a>
      
        @endif





        
     </div>
</div>
@endsection