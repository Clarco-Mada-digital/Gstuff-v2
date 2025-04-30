@extends('layouts.base')
@php
    use Carbon\Carbon;
@endphp

@section('pageTitle')
    Mon compte
@endsection

@section('content')
<div x-data="{ couvertureForm: false }">
    <div x-on:click.stop="$dispatch('img-modal', {  imgModalSrc: '{{ $couverture_image = $user->couverture_image }}' ? '{{ asset('storage/couvertures/' . $couverture_image) }}' : '{{ asset('images/Logo_lg.svg') }}', imgModalDesc: '' })" class="relative w-full max-h-[30vh] min-h-[30vh] overflow-hidden" style="background: url({{ $user->couverture_image ? asset('storage/couvertures/' . $user->couverture_image) : asset('images/Logo_lg.svg') }}) center center /cover;">
        <button x-on:click.stop="couvertureForm = !couvertureForm" class="absolute hidden shadow-xl p-2 rounded-md right-2 bottom-1 md:flex items-end gap-2 text-amber-300 hover:text-green-gs"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
            </svg> Modifier photo de couverture</button>
    </div>


    <div x-data="{ pageSection: $persist('compte'), userType: '{{ $user->profile_type }}', completionPercentage: 0, dropdownData: '', fetchCompletionPercentage() { fetch('/profile-completion-percentage').then(response => response.json()).then(data => { this.completionPercentage = data.percentage; }); }, fetchDropdownData() { fetch('/dropdown-data').then(response => response.json()).then(data => { this.dropdownData = data; }); } }" x-init="fetchCompletionPercentage()" class="container flex flex-col xl:flex-row justify-center mx-auto">

        {{-- Left section profile --}}
        <div x-data="{ profileForm: false }" class="min-w-1/4 flex flex-col items-center gap-3">

            <div class="w-55 h-55  -translate-y-[50%] rounded-full border-5 border-white mx-auto">
                <img x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ $avatar = auth()->user()->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })" class="w-full h-full rounded-full object-center object-cover" @if ($avatar=auth()->user()->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                @else
                src="{{ asset('images/icon_logo.png') }}" @endif
                alt="image profile" />
            </div>
            <a href="#" class="flex md:hidden items-center gap-3 -mt-[25%] ">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                </svg>
                Modifier photo de couverture
            </a>
            <button x-on:click="profileForm = !profileForm" class="flex items-center gap-3 md:-mt-[10%] xl:-mt-[25%] cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M15.275 12.475L11.525 8.7L14.3 5.95l-.725-.725L8.1 10.7L6.7 9.3l5.45-5.475q.6-.6 1.413-.6t1.412.6l.725.725l1.25-1.25q.3-.3.713-.3t.712.3L20.7 5.625q.3.3.3.713t-.3.712zM6.75 21H3v-3.75l7.1-7.125l3.775 3.75z" />
                </svg>
                Modifier photo de profil
            </button>
            <div x-show="profileForm" x-data="imageViewer('')" class="w-full border border-gray-300 shadow rounded-lg p-4">
                <form action="{{ route('profile.update-photo') }}" method="post" enctype="multipart/form-data" class="w-full flex flex-col justify-center gap-5">
                    @csrf()
                    <h3 class="font-dm-serif text-sm text-green-gs text-center">Modifier photo de profile</h3>
                    <template x-if="imageUrl">
                        <img :src="imageUrl" class="object-cover rounded-md border border-gray-200 mx-auto" style="width: 100px; height: 100px;">
                    </template>
                    <input name="photo_profil" type="file" accept="image/*" x-on:change="fileChosen($event)" class="mt-2" />
                    <button type="submit" class="btn-gs-gradient font-bold py-2 px-4 rounded">Mettre à jour</button>
                </form>
            </div>
            <p class="font-bold">{{ $user->pseudo ?? ($user->prenom ?? $user->nom_salon) }}</p>
            <div class="flex items-center justify-center gap-2 text-green-gs">
                <a href="#" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none">
                        <path d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg> {{ $user->canton['nom'] ?? 'Non renseigner' }}</a>
                <a href="tel:{{ $user->telephone }}" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21z" />
                    </svg> {{ $user->telephone ?? 'Non renseigner' }}</a>
            </div>
            @if ($user->profile_type == 'salon')
            <div class="flex items-center justify-center gap-2 text-green-gs">
                <a href="#" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <!-- Icon from All by undefined - undefined -->
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M24 43.5c9.043-3.117 15.488-10.363 16.5-19.589c.28-4.005.256-8.025-.072-12.027a2.54 2.54 0 0 0-2.467-2.366c-4.091-.126-8.846-.808-12.52-4.427a2.05 2.05 0 0 0-2.881 0c-3.675 3.619-8.43 4.301-12.52 4.427a2.54 2.54 0 0 0-2.468 2.366A79.4 79.4 0 0 0 7.5 23.911C8.51 33.137 14.957 40.383 24 43.5" />
                        <circle cx="24" cy="20.206" r="4.299" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M31.589 32.093a7.589 7.589 0 1 0-15.178 0" />
                    </svg> Récrutement : {{ $user->recrutement }}</a>
            </div>
            @endif
            <hr class="w-full h-2">

            <button data-modal-target="addInfoProf" data-modal-toggle="addInfoProf" class="w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">Amelioré mon profile
            </button>
            <a href="{{ route('profile.visibility.update') }}" class="w-full p-2 text-green-gs text-sm text-center rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">Visibilité de mon profile
            </a>
            @if ($user->profile_type === 'escorte')
            <x-gestion-invitation :user="$user" :invitations-recus="$invitationsRecus" :list-invitation-salons="$listInvitationSalons" :salon-associers="$salonAssociers" />
            @elseif ($user->profile_type === 'salon')
            <x-gestion-invitation :user="$user" :invitations-recus="$invitationsRecus" :list-invitation-salons="$listInvitation" :salon-associers="$salonAssociers" />
            @endif

            <div class="w-full flex flex-col gap-0 items-center mb-5">
                <button x-on:click="pageSection='compte'" :class="pageSection == 'compte' ? 'bg-green-gs text-white rounded-md' : ''" class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Mon
                    compte</button>
                <button x-show="userType == 'invite'" x-on:click="pageSection='favoris'" :class="pageSection == 'favoris' ? 'bg-green-gs text-white rounded-md' : ''" class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Mes
                    favoris</button>
                <button x-show="userType != 'invite'" x-on:click="pageSection='galerie'" :class="pageSection == 'galerie' ? 'bg-green-gs text-white rounded-md' : ''" class="w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Galerie</button>
                <button x-on:click="pageSection='discussion'" :class="pageSection == 'discussion' ? 'bg-green-gs text-white rounded-md' : ''" class="flex items-center w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white">Discussion
                    @if ($messageNoSeen > 0)
                    <span class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-red-800 bg-red-200 rounded-full">{{ $messageNoSeen }}</span>
                    @endif
                </button>
                @if($escorteCreateByUser->isNotEmpty())
                <x-gestion-escorte-creer :escorteCreateByUser="$escorteCreateByUser"/>
                @endif


            </div>

            




        </div>




        {{-- Modale pour l'amelioration du profile --}}
        <div x-data="multiStepForm()" x-init="fetchDropdownData();" id="addInfoProf" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <!-- Modale -->
            <div class="bg-white rounded-lg shadow-lg p-6 w-[90vw] max-h-[90vh] xl:max-w-7xl overflow-y-auto">

                <!-- Étapes -->
                <div class="w-full flex justify-between gap-5 mb-6">
                    <template class="w-full" x-for="(step, index) in steps" :key="index">
                        <div :class="index < steps.length - 1 ? 'w-full' : 'w-auto xl:w-full'" class="flex items-center justify-start">
                            <div x-on:click="currentStep=index" class="w-8 h-8 flex mx-2 items-center justify-center rounded-full cursor-pointer" :class="{

                                        'bg-amber-400 text-white': index < currentStep,
                                        'bg-blue-500 text-white animate-bounce': index === currentStep,
                                        'bg-gray-300 text-gray-600': index > currentStep
                                    }">
                                <span x-text="index + 1"></span>
                            </div>
                            <span class="hidden xl:block" :class="{ 'text-amber-400': index < currentStep }" x-text="step"></span>
                            <span :class="index < steps.length - 1 ? 'flex' : 'hidden'" class="flex-1 w-16 h-1 bg-gray-300 md:mx-1"></span>
                        </div>
                    </template>
                </div>

                <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                    <div class="bg-amber-600 text-xs font-medium text-amber-100 text-center p-0.5 leading-none rounded-full" :style="`width: ${completionPercentage}%`" x-text=`${completionPercentage}%`></div>
                </div>

                <!-- Contenu du formulaire -->
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <!-- Étape 1: Informations personnelles -->
                    <div x-data="{ cantons: {{ $cantons }}, selectedCanton: {{ $user->canton?->id ?? 1 }}, villes: {{ $villes }}, availableVilles: {{ $villes }} }" x-show="currentStep === 0">
                        <h2 class="text-lg font-semibold mb-4">Informations personnelles</h2>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">intitule</label>
                            <div class="flex">
                                <div id="states-button" data-dropdown-toggle="dropdown-states" class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-50 border border-e-0 border-gray-300 rounded-s-lg focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600" type="button">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <path fill="currentColor" d="M208 20h-40a12 12 0 0 0 0 24h11l-15.64 15.67A68 68 0 1 0 108 178.92V192H88a12 12 0 0 0 0 24h20v16a12 12 0 0 0 24 0v-16h20a12 12 0 0 0 0-24h-20v-13.08a67.93 67.93 0 0 0 46.9-100.84L196 61v11a12 12 0 0 0 24 0V32a12 12 0 0 0-12-12m-88 136a44 44 0 1 1 44-44a44.05 44.05 0 0 1-44 44" />
                                    </svg>
                                </div>
                                <select name="genre" id="intitule" class="bg-gray-50 border border-s-0 border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 block w-full p-2.5 ps-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white ">
                                    <option hidden value=""> -- </option>
                                    @foreach ($genres as $genre)
                                    <option value="{{ $genre }}" @if ($user->genre == $genre) selected @endif>{{ $genre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if ($user->profile_type == 'salon')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nom du proprietaire</label>
                            <input type="text" name="nom_proprietaire" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->nom_proprietaire }}">
                        </div>
                        @endif
                        @if ($user->profile_type == 'escorte')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <!-- Icon from All by undefined - undefined -->
                                        <path fill="currentColor" d="M5.85 17.1q1.275-.975 2.85-1.537T12 15t3.3.563t2.85 1.537q.875-1.025 1.363-2.325T20 12q0-3.325-2.337-5.663T12 4T6.337 6.338T4 12q0 1.475.488 2.775T5.85 17.1M12 13q-1.475 0-2.488-1.012T8.5 9.5t1.013-2.488T12 6t2.488 1.013T15.5 9.5t-1.012 2.488T12 13m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
                                    </svg>
                                </div>
                                <input type="text" id="name" name="prenom" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->prenom }}" />
                            </div>
                        </div>
                        @endif
                        @if ($user->profile_type == 'invite')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Pseudo</label>
                            <input type="text" name="pseudo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->pseudo }}">
                        </div>
                        @endif
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <!-- Icon from All by undefined - undefined -->
                                        <path fill="currentColor" d="M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12v1.45q0 1.475-1.012 2.513T18.5 17q-.875 0-1.65-.375t-1.3-1.075q-.725.725-1.638 1.088T12 17q-2.075 0-3.537-1.463T7 12t1.463-3.537T12 7t3.538 1.463T17 12v1.45q0 .65.425 1.1T18.5 15t1.075-.45t.425-1.1V12q0-3.35-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20h4q.425 0 .713.288T17 21t-.288.713T16 22zm0-7q1.25 0 2.125-.875T15 12t-.875-2.125T12 9t-2.125.875T9 12t.875 2.125T12 15" />
                                    </svg>
                                </div>
                                <input type="email" id="phone-input" name="email" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->email }}" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Numéro téléphone</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                                        <path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                                    </svg>
                                </div>
                                <input type="text" id="phone-input" name="telephone" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->telephone }}" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Adresse</label>
                            <input type="text" name="adresse" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->adresse }}">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">NPA</label>
                            <input type="text" name="npa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->npa }}">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Canton</label>
                            <select x-model="selectedCanton" x-on:change="villes = availableVilles.filter(ville => ville.canton_id == selectedCanton)" name="canton" id="canton" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                <template x-for="canton in cantons" :key="canton.id">
                                    <option :value=canton.id :selected="'{{ $user->canton['id'] ?? '' }}' == canton.id ? true : false" x-text="canton.nom"></option>
                                </template>

                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Ville</label>
                            <select name="ville" id="ville" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="localStorage.setItem('villeNom', this.options[this.selectedIndex].text);">
                                <option hidden value=""> -- </option>
                                <template x-for="ville in villes" :key="ville.id">
                                    <option :value=ville.id :selected="'{{ $user->ville }}' == ville.id ? true : false" x-text="ville.nom"></option>
                                </template>

                            </select>
                        </div>
                    </div>

                    <!-- Étape 2: Informations professionnelles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5" :class="userType == 'invite' ? 'hidden' : ''" x-show="currentStep === 1">
                        <h2 class="text-lg font-semibold mb-4 col-span-2">Informations professionnelles</h2>
                        @if ($user->profile_type == 'salon')
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Catégories</label>
                            <select name="categorie" id="salon_categorie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($salon_categories as $categorie)
                                <option value={{ $categorie['id'] }} @if ($user->categorie ? $user->categorie['id'] == $categorie->id : false) selected @endif>{{ $categorie['nom'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Recrutement</label>
                            <select name="recrutement" id="recrutement" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                <option value="Ouvert" @if ($user->recrutement == 'Ouvert') selected @endif>Ouvert
                                </option>
                                <option value="Fermé" @if ($user->recrutement == 'Fermé') selected @endif>Fermer
                                </option>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Numbre des filles</label>
                            <select name="nombre_filles" id="nombre_filles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($nombre_filles as $nb_fille)
                                <option value="{{ $nb_fille }}" @if ($user->nombre_filles == $nb_fille) selected @endif> {{ $nb_fille }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if ($user->profile_type == 'escorte')
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Catégories</label>
                            <select name="categorie" id="escort_categorie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($escort_categories as $categorie)
                                <option value={{ $categorie['id'] }} @if ($user->categorie ? $user->categorie['id'] == $categorie->id : false) selected @endif>{{ $categorie['nom'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Pratique sexuels</label>
                            <select name="pratique_sexuelles" id="pratique_sexuelles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($pratiquesSexuelles as $pratique)
                                <option value="{{ $pratique }}" @if ($user->pratique_sexuelles == $pratique) selected @endif>{{ $pratique }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Oriantation sexuels</label>
                            <select name="oriantation_sexuelles" id="oriantation_sexuelles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($oriantationSexuelles as $oriantation)
                                <option value="{{ $oriantation }}" @if ($user->oriantation_sexuelles == $oriantation) selected @endif>{{ $oriantation }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Services</label>
                            <x-select_object_multiple name="service" :options="$services" :value="$user->service" label="Mes services" />
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Tailles en cm</label>
                            <input class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" type="number" name="tailles" id="taille" placeholder="taille en cm" value="{{ $user->tailles }}">
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Origine</label>
                            <select name="origine" id="origine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($origines as $origine)
                                <option value="{{ $origine }}" @if ($user->origine == $origine) selected @endif>{{ $origine }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Couleur des yeux</label>
                            <select name="couleur_yeux" id="couleur_yeux" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($couleursYeux as $yeux)
                                <option value="{{ $yeux }}" @if ($user->couleur_yeux == $yeux) selected @endif>{{ $yeux }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Couleur des cheveux</label>
                            <select name="couleur_cheveux" id="couleur_cheveux" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($couleursCheveux as $cheveux)
                                <option value="{{ $cheveux }}" @if ($user->couleur_cheveux == $cheveux) selected @endif>{{ $cheveux }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Mensuration</label>
                            <select name="mensuration" id="mensuration" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($mensurations as $mensuration)
                                <option value="{{ $mensuration }}" @if ($user->mensuration == $mensuration) selected @endif>{{ $mensuration }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Poitrine</label>
                            <select name="poitrine" id="poitrine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($poitrines as $poitrine)
                                <option value="{{ $poitrine }}" @if ($user->poitrine == $poitrine) selected @endif>{{ $poitrine }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Taille de poitrine</label>
                            <select id="taille_poitrine" name="taille_poitrine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($taillesPoitrine as $taillePoitrine)
                                <option value="{{ $taillePoitrine }}" @if ($user->taille_poitrine == $taillePoitrine) selected @endif>{{ $taillePoitrine }}
                                </option>
                                @endforeach
                            </select>
                            </template>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Poils du pubis</label>
                            <select id="pubis" name="pubis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($pubis as $pubi)
                                <option value="{{ $pubi }}" @if ($user->pubis == $pubi) selected @endif>{{ $pubi }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Tatouages</label>
                            <select id="tatouages" name="tatouages" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($tatouages as $tatou)
                                <option value="{{ $tatou }}" @if ($user->tatouages == $tatou) selected @endif>{{ $tatou }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Mobilité</label>
                            <select id="mobilete" name="mobilite" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($mobilites as $mobilite)
                                <option value="{{ $mobilite }}" @if ($user->mobilite == $mobilite) selected @endif>{{ $mobilite }}
                                </option>
                                @endforeach
                            </select>
                            </select>
                        </div>
                        @endif
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Langue</label>
                            <x-select_multiple name="langues" :options="$langues" :value="explode(',', $user->langues)" label="Langue parler" />
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Tarif</label>
                            <select id="tarif" name="tarif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option hidden> -- </option>
                                @foreach ($tarifs as $tarif)
                                <option value="{{ $tarif }}" @if ($user->tarif == $tarif) selected @endif>A partir de
                                    {{ $tarif }}.-CHF</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 col-span-2 md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Moyen de paiement</label>
                            <x-select_multiple name="paiement" :options="$paiements" :value="explode(',', $user->paiement)" label="Paiment" />
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Apropos</label>
                            <textarea rows="4" name="apropos" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">{{ $user->apropos ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Étape 3: Informations complémentaires -->
                    <div @if ($user->profile_type == 'invite') x-show="currentStep === 1" @else x-show="currentStep === 2" @endif>
                        <h2 class="text-lg font-semibold mb-4">Informations complémentaires</h2>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Autre contact</label>
                            <input type="text" name="autre_contact" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->autre_contact }}" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Complement d'adresse</label>
                            <input type="text" name="complement_adresse" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->complement_adresse }}" />
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Lien site web</label>
                            <input type="url" name="lien_site_web" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->lien_site_web }}" />
                        </div>

                        <x-location-selector user='{{ $user->id }}' />

                    </div>

                    <!-- Boutons de navigation -->
                    <div class="flex justify-between gap-2 mt-6 text-sm md:text-base">
                        <button type="button" @click="prevStep" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md" x-show="currentStep > 0">
                            Précédent
                        </button>
                        <button type="button" @click="saveAndQuit" class="px-4 py-2 bg-amber-500 text-white rounded-md" x-show="currentStep < steps.length - 1">
                            Enregister et quiter
                        </button>
                        <button type="button" @click="nextStep" class="px-4 py-2 bg-blue-500 text-white rounded-md" x-show="currentStep < steps.length - 1">
                            Suivant
                        </button>
                        <button id="addInfoSubmit" type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md" x-show="currentStep === steps.length - 1">
                            Soumettre
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right section profile --}}
        <div class="flex flex-col gap-5 min-w-3/4 px-5 py-5">

            <div x-show="couvertureForm" x-data="imageViewer('')" class="w-full border border-gray-300 shadow rounded-lg p-4">
                <form action="{{ route('profile.update-photo') }}" method="post" enctype="multipart/form-data" class="w-full flex flex-col justify-center gap-5">
                    @csrf()
                    <h3 class="font-dm-serif text-sm text-green-gs text-center">Modifier photo de couverture</h3>
                    <template x-if="imageUrl">
                        <img :src="imageUrl" class="object-cover rounded-md border border-gray-200 mx-auto" style="width: 100px; height: 100px;">
                    </template>
                    <input name="photo_couverture" type="file" accept="image/*" x-on:change="fileChosen($event)" class="mt-2" />
                    <button type="submit" class="btn-gs-gradient font-bold py-2 px-4 rounded">Mettre à jour</button>
                </form>
            </div>

            {{-- Message --}}
            <div x-show="completionPercentage != 100" class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Danger</span>
                <div class="text-dm-serif">
                    <span class="font-bold">Votre profil est actuellement rempli à <span x-text=`${completionPercentage}%`></span> </span>
                    <div class="my-1.5">
                        Pour profiter pleinement des services offerts par Gstuff, nous vous recommandons vivement de
                        compléter vos informations avec des données réelles. Chez Gstuff, nous nous engageons à
                        respecter votre vie privée. Toutes les données collectées sont utilisées pour vous offrir une
                        expérience optimale sur la plateforme. Consultez notre politique de confidentialité ici : <a class="font-bold" href="{{ route('static.pdc') }}">Politique de confidentialité</a>
                    </div>
                    <button data-modal-target="addInfoProf" data-modal-toggle="addInfoProf" class="font-dm-serif font-bold border text-green-gs border-green-600 px-2 py-1 hover:bg-green-gs hover:text-white rounded-lg transition-all">Amelioré
                        mon profile</button>
                </div>
            </div>

            {{-- Invitation --}}
            @if($user->profile_type === 'escorte' || $user->profile_type === 'salon')
            <x-invitation-list :invitationsRecus="$invitationsRecus" type='{{$user->profile_type}}' />
            @endif

            {{-- Pour l'invité --}}
            <div x-show="userType=='invite'">

                {{-- Section mon compte --}}
                <section x-show="pageSection=='compte'">

                    {{-- Information --}}
                    <div class="flex items-center justify-between py-5">
                        <h2 class="font-dm-serif font-bold text-2xl">Mes informations</h2>
                        {{-- <button class="flex items-center gap-2 text-amber-400"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z"/></svg> <span class="hidden md:block">Modifier mes informations</span></button> --}}
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 items-center gap-10">
                        <span class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M5.85 17.1q1.275-.975 2.85-1.537T12 15t3.3.563t2.85 1.537q.875-1.025 1.363-2.325T20 12q0-3.325-2.337-5.663T12 4T6.337 6.338T4 12q0 1.475.488 2.775T5.85 17.1M12 13q-1.475 0-2.488-1.012T8.5 9.5t1.013-2.488T12 6t2.488 1.013T15.5 9.5t-1.012 2.488T12 13m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
                            </svg> {{ $user->pseudo }}</span>
                        <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                <path fill="currentColor" fill-rule="evenodd" d="M14.5 8a6.5 6.5 0 1 1-13 0a6.5 6.5 0 0 1 13 0M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-9.75 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-1V7H7a.75.75 0 0 0 0 1.5h.25v2zM8 6a1 1 0 1 0 0-2a1 1 0 0 0 0 2" clip-rule="evenodd" />
                            </svg> {{ Carbon::parse($user->date_naissance)->age }} ans</span>
                        <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M208 20h-40a12 12 0 0 0 0 24h11l-15.64 15.67A68 68 0 1 0 108 178.92V192H88a12 12 0 0 0 0 24h20v16a12 12 0 0 0 24 0v-16h20a12 12 0 0 0 0-24h-20v-13.08a67.93 67.93 0 0 0 46.9-100.84L196 61v11a12 12 0 0 0 24 0V32a12 12 0 0 0-12-12m-88 136a44 44 0 1 1 44-44a44.05 44.05 0 0 1-44 44" />
                            </svg> Homme</span>
                        <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4.35 20.7q-.5.2-.925-.112T3 19.75v-14q0-.325.188-.575T3.7 4.8L9 3l6 2.1l4.65-1.8q.5-.2.925.113T21 4.25v8.425q-.875-1.275-2.187-1.975T16 10q-.5 0-1 .088t-1 .262v-3.5l-4-1.4v13.075zM20.6 22l-2.55-2.55q-.45.275-.962.413T16 20q-1.65 0-2.825-1.175T12 16t1.175-2.825T16 12t2.825 1.175T20 16q0 .575-.137 1.088t-.413.962L22 20.6zM16 18q.85 0 1.413-.5T18 16q.025-.85-.562-1.425T16 14t-1.425.575T14 16t.575 1.425T16 18" />
                            </svg> Vaud - Bex</span>
                    </div>

                    {{-- Favoris --}}
                    <div class="flex items-center justify-center md:justify-start py-5">
                        <h2 class="font-dm-serif font-bold text-2xl">Mes favoris</h2>
                    </div>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-3 w-full">
                        <div class="xl:w-1/2 flex flex-col items-center justify-center gap-4 min-w-full">
                            <h3 class="font-dm-serif text-xl text-green-gs">Mes escortes favoris</h3>
                            @if ($escortFavorites != '[]')
                            <div class="w-full grid grid-cols-1 md:grid-cols-1 2xl:grid-cols-2 items-center mb-4 gap-2">
                                @foreach ($escortFavorites as $favorie)
                                <livewire:escort-card name="{{ $favorie->prenom }}" canton="{{ $favorie->canton['nom'] ?? '' }}" ville="{{ $favorie->ville['nom'] ?? '' }}" avatar='{{ $favorie->avatar }}' escortId="{{ $favorie->id }}" />
                                @endforeach
                            </div>
                            @else
                            <div>Aucun favoris escorte pour l'instant</div>
                            @endif
                        </div>
                        <div class="xl:w-1/2 flex flex-col items-center justify-center gap-4 min-w-full">
                            <h3 class="font-dm-serif text-xl text-green-gs">Mes salons favoris</h3>
                            @if ($salonFavorites != '[]')
                            <div class="w-full grid grid-cols-1 md:grid-cols-1 2xl:grid-cols-2 items-center mb-4 gap-2">
                                @foreach ($salonFavorites as $favorie)
                                <livewire:escort-card name="{{ $favorie->prenom }}" canton="{{ $favorie->canton['nom'] }}" ville="{{ $favorie->ville['nom'] }}" avatar='{{ $favorie->avatar }}' escortId="{{ $favorie->id }}" />
                                @endforeach
                            </div>
                            @else
                            <div>Aucun favoris salon pour l'instant</div>
                            @endif
                        </div>
                    </div>
                    @if ($user && $user->id)
                    <div>
                        <livewire:approximate userId="{{ $user->id }}" />
                    </div>
                    @endif


                </section>

                {{-- Section favoris --}}
                <section x-show="pageSection=='favoris'">
                    <div class="flex items-center gap-5 py-5">
                        <h2 class="font-dm-serif font-bold text-2xl">Mes favoris</h2>
                        <div class="flex-1 w-full h-1 bg-green-gs"></div>
                    </div>
                    <div class="grid grid-cols-1 w-full">
                        <div class="relative xl:w-1/2 flex flex-col items-center justify-center gap-5 min-w-full">
                            <h3 class="font-dm-serif text-xl text-green-gs">Mes escortes favoris</h3>
                            @if ($escortFavorites != '[]')
                            <div id="NewEscortContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-5 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                                @foreach ($escortFavorites as $escort)
                                <livewire:escort-card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] }}" ville="{{ $escort->ville['nom'] }}" avatar='{{ $escort->avatar }}' escortId='{{ $escort->id }}' />
                                @endforeach
                            </div>
                            <div id="arrowEscortScrollRight" class="absolute 2xl:hidden top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                                </svg>
                            </div>
                            <div id="arrowEscortScrollLeft" class="absolute 2xl:hidden top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                                </svg>
                            </div>
                            @else
                            <div>Aucun favoris escorte pour l'instant</div>
                            @endif
                        </div>
                        <div class="xl:w-1/2 flex flex-col items-center justify-center gap-5 min-w-full">
                            <h3 class="font-dm-serif text-xl text-green-gs">Mes salons favoris</h3>
                            @if ($salonFavorites != '[]')
                            <div id="NewEscortContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-5 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                                @foreach ($salonFavorites as $escort)
                                <livewire:escort-card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] }}" ville="{{ $escort->ville['nom'] }}" avatar='{{ $escort->avatar }}' escortId='{{ $escort->id }}' />
                                @endforeach
                            </div>
                            <div id="arrowEscortScrollRight" class="absolute 2xl:hidden top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                                </svg>
                            </div>
                            <div id="arrowEscortScrollLeft" class="absolute 2xl:hidden top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                                </svg>
                            </div>
                            @else
                            <div>Aucun favoris escorte pour l'instant</div>
                            @endif
                        </div>
                    </div>
                </section>

            </div>

            {{-- Pour l'escort --}}
            <div x-show="userType=='escorte'">

                {{-- Pour la vérification --}}
                @if ($user->profile_verifie === 'verifier')
                <div class="w-full p-5 rounded-xl flex items-center justify-between border border-blue-gs text-blue-gs">
                    <p class="flex items-center">
                        <i class="fas fa-check-circle text-blue-gs mr-2"></i>
                        Votre profil est vérifié. Félicitations !
                    </p>
                </div>
                @elseif($user->profile_verifie === 'non verifier')
                <div class="w-full p-5 rounded-xl flex items-center justify-between border border-green-gs text-green-gs">
                    <p>Votre profil n'est pas vérifié. Envoyez une demande de vérification.</p>
                    <button data-modal-target="requestModal" data-modal-toggle="requestModal" class="btn-gs-gradient text-black">
                        Envoyer une demande
                    </button>
                </div>
                @elseif($user->profile_verifie === 'en cours')
                <div class="w-full p-5 rounded-xl flex items-center justify-between border border-green-gs text-green-gs">
                    <p>Votre profil est en cours de validation.</p>
                </div>
                @endif

                <!-- Modal Structure -->
                <div id="requestModal" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-[50vw] max-h-[90vh] xl:max-w-7xl overflow-y-auto">
                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs  mb-5">Envoyer votre photo de
                            vérification </h2>
                        <h2 class="font-dm-serif  text-sm   mb-2">Envoyez-nous une photo de vous en tenant un papier
                            écrit << Gstuff>> et la date du jour à la quelle vous avez pris la photo</h2>
                        <div x-data="imageViewer('')" class="w-full border border-gray-300 shadow rounded-lg p-4">
                            <form action="{{ route('profile.updateVerification') }}" method="post" enctype="multipart/form-data" class="w-full flex flex-col justify-center gap-5">
                                @csrf()
                                <h3 class="font-dm-serif text-sm text-green-gs text-center">Image de vérification</h3>
                                <template x-if="imageUrl">
                                    <img :src="imageUrl" class="object-cover rounded-md border border-gray-200 mx-auto" style="width: 100px; height: 100px;">
                                </template>
                                <input name="image_verification" type="file" accept="image/*" x-on:change="fileChosen($event)" class="mt-2" />
                                <input type="hidden" name="profile_verifie" value="en cours">
                                <button type="submit" class="btn-gs-gradient font-bold py-2 px-4 rounded">Envoyer</button>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- Section mon compte --}}
                <section x-show="pageSection=='compte'">

                    {{-- Storie --}}
                    <div class="flex items-center justify-between gap-5 py-5">

                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Stories</h2>
                        <div class="flex-1 h-0.5 bg-green-gs"></div>
                        <button class="flex items-center gap-2 text-amber-400">
                            Ajouter
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                            </svg>
                        </button>

                    </div>
                    <div class="flex items-center gap-10 flex-wrap">
                        @livewire('create-story')
                        @livewire('stories-viewer', ['userViewStorie' => $user->id], key($user->id))
                    </div>

                    {{-- Galerie --}}
                    <div class="w-full flex items-center gap-10 flex-wrap">
                        {{-- <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun stories trovée !</span> --}}
                        @livewire('gallery-manager', ['user' => $user], key($user->id))
                    </div>

                    {{-- A propos de moi --}}
                    <div class="flex items-center justify-between gap-5 py-5">

                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">A propos de moi</h2>
                        <div class="flex-1 h-0.5 bg-green-gs"></div>

                    </div>
                    <div class="flex items-center gap-10 flex-wrap">
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 w-full">
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/age_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Age : {{ Carbon::parse($user->date_naissance)->age }} ans</span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/origine_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Origine : {{ $user->origine ?? '-' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/langue_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Langue : {{ $user->langues }}</span>
                            </div>

                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/yeux_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Couleur des yeux : {{ $user->couleur_yeux ?? '-' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/cheveux_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Couleur des cheveux : {{ $user->couleur_cheveux ?? '-' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/tarif_icon.svg') }}" alt="age icon" srcset="age icon">
                                @if ($user->tarif)
                                <span>Tarifs à partir de {{ $user->tarif }}.-CHF</span>
                                @else
                                <span>Contacter moi pour connaitre mes tarifs </span>
                                @endif
                            </div>

                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/taille_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Taille : +/- {{ $user->tailles ?? '-' }}cm </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/poitrine_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Poitrine : {{ $user->poitrine ?? '-' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/mobilite.svg') }}" alt="age icon" srcset="age icon">
                                <span>Mobilité : {{ $user->mobilite ?? '-' }}</span>
                            </div>

                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/mensuration.svg') }}" alt="age icon" srcset="age icon">
                                <span>Mensurations : {{ $user->mensuration ?? '-' }}</span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/taill_poit.svg') }}" alt="age icon" srcset="age icon">
                                <span>Taille de poitrine : {{ 'Bonnet ' . $user->taille_poitrine ?? '?' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/cart_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Moyen de paiement : {{ $user->paiement }}</span>
                            </div>

                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="flex items-center justify-between gap-5 py-5">
                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Description</h2>
                        <div class="flex-1 h-0.5 bg-green-gs"></div>
                    </div>
                    <div class="flex items-center gap-10 flex-wrap">
                        <p class="text-justify">{{ $user->apropos ?? '-' }} </p>
                    </div>

                    {{-- Service --}}
                    <div class="flex items-center justify-between gap-5 py-5">
                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Services proposés</h2>
                        <div class="flex-1 h-0.5 bg-green-gs"></div>
                    </div>
                    <div class="flex flex-col justify-center gap-5 flex-wrap">
                        <div class="flex items-center gap-5 font-dm-serif font-bold text-green-gs">
                            Catégories
                            <button class="flex items-center gap-2 text-amber-400">
                                Modifier
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-5">
                            <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">{{ $user->categorie['nom'] ?? '' }}</span>
                        </div>

                        <div class="flex items-center gap-5 font-dm-serif font-bold text-green-gs">
                            Services fournies
                            <button class="flex items-center gap-2 text-amber-400">
                                Modifier
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-5">
                            @foreach ($user->service as $service)
                            <span class="px-2 border border-green-gs text-green-gs rounded-lg hover:bg-amber-300">{{ $service['nom'] ?? '' }}</span>
                            @endforeach
                        </div>

                    </div>

                    {{-- Salon associé --}}
                    <div class="flex items-center justify-between gap-5 py-5">

                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Salon associé</h2>
                        <div class="flex-1 h-0.5 bg-green-gs"></div>
                        <button data-modal-target="sendInvitationSalon" data-modal-toggle="sendInvitationSalon" class="flex items-center gap-2 text-amber-400 cursor-pointer">
                            Invité un salon
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                            </svg>
                        </button>

                    </div>
                    <div class="w-full flex items-center gap-10 flex-wrap">
                        @if($salonAssociers->isNotEmpty())
                        @foreach ($salonAssociers as $salonAssocier)

                        @if($salonAssocier->type === "associe au salon")
                        <livewire:salon-card name="{{ $salonAssocier->invited->nom_salon}}" canton="{{$salonAssocier->invited->cantonget->nom ?? 'Inconue'}}" ville="{{$salonAssocier->invited->villeget->nom  ?? 'Inconue'}}" avatar='{{$salonAssocier->invited->avatar}}' salonId='{{$salonAssocier->invited->id}}' wire:key="{{$salonAssocier->invited->id}}" />

                        @else
                        <livewire:salon-card name="{{ $salonAssocier->inviter->nom_salon}}" canton="{{$salonAssocier->inviter->cantonget->nom ?? 'Inconue'}}" ville="{{$salonAssocier->inviter->villeget->nom  ?? 'Inconue'}}" avatar='{{$salonAssocier->inviter->avatar}}' salonId='{{$salonAssocier->inviter->id}}' wire:key="{{$salonAssocier->inviter->id}}" />

                        @endif
                        @endforeach
                        @else
                        <span class="w-full text-center text-green-gs font-bold font-dm-serif">Aucun salon associé pour l'instant</span>
                        @endif
                    </div>
                    {{-- Modale pour l'invitation escort --}}
                    <div x-data="" x-init="" id="sendInvitationSalon" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <!-- Modale -->
                        <x-invitation-tabs-escorte :salonsNoInvited="$salonsNoInvited" :listInvitationSalon="$listInvitationSalons" />
                    </div>

                    {{-- Galerie privée --}}
                    @livewire('gallery-manager', ['user' => $user, 'isPublic' => false], key($user->id))

                </section>

                {{-- Section galerie --}}
                <section x-show="pageSection=='galerie'">
                    @livewire('gallery-manager', ['user' => $user], key($user->id))
                </section>

            </div>

            {{-- Pour salon --}}
            <div x-show="userType=='salon'">

                {{-- Section mon compte --}}
                <section x-show="pageSection=='compte'">

                    {{-- Galerie --}}
                    @livewire('gallery-manager', ['user' => $user], key($user->id))

                    {{-- Description --}}
                    <div class="flex items-center justify-between gap-5 py-5">

                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Description</h2>
                        <div class="flex-1 h-0.5 bg-green-gs"></div>

                    </div>
                    <div class="flex items-center gap-10 flex-wrap">
                        <p class="text-justify text-sm xl:text-base"> {{ $user->apropos ?? '-' }} </p>
                    </div>

                    {{-- A propos de moi --}}
                    <div class="flex items-center justify-between gap-5 py-5">
                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">A propos de moi</h2>
                        <div class="flex-1 h-0.5 bg-green-gs"></div>
                    </div>
                    <div class="flex items-center gap-10 flex-wrap">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 w-full">
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/origine_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Catégorie : {{ $user->categorie['nom'] ?? '-' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/langue_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Nombre des filles : {{ $user->nombre_filles }} filles</span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/langue_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Langue : {{ $user->langues }}</span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/yeux_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Autre contact : {{ $user->autre_contact ?? '-' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/cheveux_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Adresse : {{ $user->adresse ?? '-' }} </span>
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/tarif_icon.svg') }}" alt="age icon" srcset="age icon">
                                @if ($user->tarif)
                                <span>Tarifs à partir de {{ $user->tarif }}.-CHF</span>
                                @else
                                <span>Contacter moi pour connaitre mes tarifs </span>
                                @endif
                            </div>
                            <div class="w-full flex items-center gap-3 font-dm-serif">
                                <img src="{{ asset('images/icons/cart_icon.svg') }}" alt="age icon" srcset="age icon">
                                <span>Moyen de paiement : {{ $user->paiement }}</span>
                            </div>

                        </div>
                    </div>

                    {{-- Escort associé --}}
                    <div class="hidden xl:flex items-center justify-between flex-col xl:flex-row gap-5 py-5">

                        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Escorte du salon</h2>
                        <div class="hidden xl:block flex-1 h-0.5 bg-green-gs"></div>


                    </div>
                    <div class="mt-10 xl:mt-0 w-full flex items-center flex-col">

                        <div class="w-full grid grid-cols-1 xl:grid-cols-2  items-center ">

                            <div class="hidden xl:flex items-center justify-between flex-col xl:flex-row gap-5 py-2">
                                <div class="xl:mr-auto">
                                    <h2 class="font-dm-serif font-bold text-2xl text-green-gs text-center">Escortes créées</h2>
                                </div>
                            </div>

                            <div class="hidden xl:flex items-center justify-between flex-col xl:flex-row gap-5 py-2">
                                <div class="xl:ml-auto">
                                    <h2 class="font-dm-serif font-bold text-2xl text-green-gs text-center">Invitée du salon</h2>
                                </div>
                            </div>

                            <div class="">
                                <h2 class="font-dm-serif font-bold text-2xl text-green-gs xl:hidden">Escorte du salon</h2>
                                <div class="flex items-center flex-wrap">
                                    @if ($escorteCreateByUser->isNotEmpty())
                                    @foreach ($escorteCreateByUser as $acceptedInvitation)
                                    <livewire:escort_card name="{{ $acceptedInvitation->prenom }}" canton="{{ $acceptedInvitation->cantonget->nom ?? 'Non spécifié' }}" ville="{{ $acceptedInvitation->villeget->nom ?? 'Non spécifié' }}" avatar="{{ $acceptedInvitation->avatar }}" escortId="{{ $acceptedInvitation->id }}" wire:key="{{ $acceptedInvitation->id }}" />
                                    @endforeach
                                    @else
                                    <span class="w-full text-sm xl:text-base text-center text-green-gs font-bold font-dm-serif">Aucun escort créer pour l'instant</span>
                                    @endif
                                </div>
                            </div>

                            <div class="">

                                <div class="flex items-center justify-around flex-wrap gap-4">
                                    @if ($acceptedInvitations->isNotEmpty())

                                    @foreach ($acceptedInvitations as $acceptedInvitation)

                                    @if($acceptedInvitation->type === "associe au salon")
                                    <livewire:escort_card name="{{$acceptedInvitation->inviter->prenom != null ? $acceptedInvitation->inviter->prenom : $acceptedInvitation->inviter->nom_salon }}" canton="{{ $acceptedInvitation->inviter->cantonget->nom ?? 'Non spécifié' }}" ville="{{ $acceptedInvitation->inviter->villeget->nom ?? 'Non spécifié' }}" avatar="{{ $acceptedInvitation->inviter->avatar }}" escortId="{{ $acceptedInvitation->inviter->id }}" wire:key="{{ $acceptedInvitation->inviter->id }}" />
                                    @else
                                    <livewire:escort_card name="{{$acceptedInvitation->invited->prenom != null ? $acceptedInvitation->invited->prenom : $acceptedInvitation->invited->nom_salon }}" canton="{{ $acceptedInvitation->invited->cantonget->nom ?? 'Non spécifié' }}" ville="{{ $acceptedInvitation->invited->villeget->nom ?? 'Non spécifié' }}" avatar="{{ $acceptedInvitation->invited->avatar }}" escortId="{{ $acceptedInvitation->invited->id }}" wire:key="{{ $acceptedInvitation->invited->id }}" />
                                    @endif

                                    @endforeach
                                    @else
                                    <span class="w-full text-sm xl:text-base text-center text-green-gs font-bold font-dm-serif">
                                        Aucun escort associé pour l'instant
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="w-full flex items-center justify-between pt-10 mb-5">

                            <button data-modal-target="createEscorte" data-modal-toggle="createEscorte" class="p-2 rounded-lg bg-green-gs text-sm xl:text-base text-white cursor-pointer hover:bg-green-800">Créer un escort</button>
                            <button data-modal-target="sendInvitationEscort" data-modal-toggle="sendInvitationEscort" class="p-2 rounded-lg bg-green-gs text-sm xl:text-base
                                text-white cursor-pointer hover:bg-green-800">Invité un escort</button>
                        </div>


                    </div>
                    {{-- Modale pour l'invitation escort --}}
                    <div x-data="" x-init="" id="sendInvitationEscort" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <!-- Modale -->
                        <x-invitation-tabs :escortsNoInvited="$escortsNoInvited" :listInvitation="$listInvitation" />
                    </div>
                    {{-- Modale pour créer un escort --}}
                    <div x-data="" x-init="" id="createEscorte" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <!-- Modale -->
                        <x-escort-form :user="$user->id" />
                    </div>

                    {{-- Galerie privée --}}
                    @livewire('gallery-manager', ['user' => $user, 'isPublic' => false], key($user->id))

                </section>

                {{-- section gallerie --}}
                <section x-show="pageSection=='galerie'">
                    @livewire('gallery-manager', ['user' => $user, 'isPublic' => true], key($user->id))
                </section>

            </div>

            {{-- Section discussion --}}
            <section x-show="pageSection=='discussion'">
                <div class="py-5">
                    <h2 class="font-dm-serif font-bold text-2xl my-5">Discussions</h2>
                    <div class="w-[90%] mx-auto h-1 bg-green-gs"></div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                {{-- <div class="card-header">Chat avec Jhone</div> --}}
                                <div class="card-body">
                                    {{-- <chat-component :receiver-id="{{ $receiver->id }}" :user-id="{{ Auth::id() }}"></chat-component> --}}
                                    {{-- <iframe src="{{route('home-messenger')}}" frameborder="0" width="100%" height="700"></iframe> --}}
                                    <x-messenger />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
</div>

@stop

@section('extraScripts')
    <script>
        function multiStepForm() {
            return {
                steps: "{{ $user->profile_type }}" == 'invite' ? ['Informations personnelles',
                    'Informations complémentaires'
                ] : ['Informations personnelles', 'Informations professionnelles', 'Informations complémentaires'],
                currentStep: 0,
                nextStep() {
                    if (this.currentStep < this.steps.length - 1) {
                        this.currentStep++;
                    }
                },
                prevStep() {
                    if (this.currentStep > 0) {
                        this.currentStep--;
                    }
                },
                saveAndQuit() {
                    document.getElementById('addInfoSubmit').click();
                },
                // submitForm() {
                //   alert('Formulaire soumis avec succès !');
                // }
            };
        }

        function imageViewer(src = '') {
            return {
                imageUrl: src,
                fileChosen(event) {
                    this.fileToDataUrl(event, src => this.imageUrl = src);
                },
                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return;
                    let file = event.target.files[0];
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = e => callback(e.target.result);
                }
            }
        }

        function storyPlayer() {
            return {
                isModalOpen: false,
                currentStory: 0,
                progress: 0,

                init() {
                    this.$wire.$on('openStory', () => {
                        this.isModalOpen = true;
                        this.startProgress();
                    });

                    this.$wire.$on('closeStory', () => {
                        this.isModalOpen = false;
                        this.progress = 0;
                    });
                },

                startProgress() {
                    const interval = setInterval(() => {
                        if (this.progress < 100) {
                            this.progress++;
                        } else {
                            this.$wire.nextStory();
                            clearInterval(interval);
                        }
                    }, 50);
                }
            }
        }

        function messenger() {
            return {
                searchQuery: '',
                typingIndicator: false,
                showInfoPanel: false,
                mediaCount: 0,
                sharedLinks: 0,
                sharedLinksCount: 0,
                messageCount: 0,
                favorites: {!! $favoriteList->map(function ($fav) {
                        return [
                            'id' => $fav->user->id,
                            'pseudo' => $fav->user->pseudo,
                            'prenom' => $fav->user->prenom,
                            'nom_salon' => $fav->user->nom_salon,
                            'avatar' => $fav->user->avatar,
                        ];
                    })->toJson() !!},
                currentChat: null,
                currentChatUser: null,
                newMessage: '',
                loadingContacts: false,
                loadingMessages: false,
                fileToUpload: null,
                preview: null,
                emojies: null,
                showEmojiPicker: false,

                init() {
                    this.loadContacts();
                    this.setupEventListeners();
                    this.getEmojies();
                },

                toggleInfoPanel() {
                    this.showInfoPanel = !this.showInfoPanel;
                    // if (this.showInfoPanel) {
                    //     this.calculateConversationStats();
                    // }
                },

                async getEmojies() {
                    await fetch('https://api.github.com/emojis')
                        .then(response => response.json())
                        .then(data => {
                            this.emojies = Object.keys(data).map(key => data[key]);
                            console.log(emojis); // Tableau d'URLs d'emojis
                        });
                },

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    if (file && file.type.match('image.*')) {
                        // this.attachment = file;
                        this.fileToUpload = file;

                        // Créer une prévisualisation
                        const reader = new FileReader();
                        reader.onload = (e) => this.preview = e.target.result;
                        reader.readAsDataURL(file);
                        handleFileUpload(event);
                    } else {
                        alert('Veuillez sélectionner une image valide');
                        return;
                    };
                },

                clearAttachment() {
                    this.newMessage = '';
                    this.fileToUpload = null;
                    this.preview = null;
                    document.querySelector('.attachment-input').value = '';
                },

                insertEmoji(emoji) {
                    this.newMessage += emoji;
                    this.showEmojiPicker = false;
                },

                setupEventListeners() {
                    // Écouteur pour le scroll des messages
                    document.getElementById('messages-container').addEventListener('scroll', (e) => {
                        if (e.target.scrollTop === 0 && this.currentChat) {
                            this.loadMoreMessages();
                        }
                    });
                },

                async searchUsers() {
                    if (!this.searchQuery.trim()) return;

                    try {
                        const response = await axios.get('/messenger/search', {
                            params: {
                                query: this.searchQuery
                            }
                        });
                        document.getElementById('search-list').innerHTML = response.data.records;
                    } catch (error) {
                        console.error(error);
                    }
                },

                async loadContacts(page = 1) {
                    this.loadingContacts = true;
                    try {
                        const response = await axios.get('/messenger/fetch-contacts', {
                            params: {
                                page
                            }
                        });
                        document.getElementById('contacts-list').innerHTML = response.data.contacts;
                    } catch (error) {
                        console.error(error);
                    } finally {
                        this.loadingContacts = false;
                    }
                },

                async loadChat(userId) {
                    this.currentChat = userId;
                    this.loadingMessages = true;

                    try {
                        // Récupérer les infos de l'utilisateur
                        const userResponse = await axios.get('/messenger/id-info', {
                            params: {
                                id: userId
                            }
                        });
                        this.currentChatUser = userResponse.data.fetch;
                        this.messageCount = userResponse.data.stats.total_messages;

                        // load gallery
                        if (userResponse.data?.shared_photos) {
                            $('.info_gallery').html(userResponse.data.shared_photos);
                            this.mediaCount = userResponse.data.stats.photos_count;
                        }
                        if(userResponse.data?.shared_links){
                            this.sharedLinks = userResponse.data.shared_links;
                            this.sharedLinksCount = userResponse.data.stats.links_count;
                        }

                        // Récupérer les messages
                        const messagesResponse = await axios.get('/messenger/fetch-messages', {
                            params: {
                                id: userId
                            }
                        });
                        document.getElementById('messages-list').innerHTML = messagesResponse.data.messages;

                        // Marquer comme lu
                        await axios.post('/messenger/make-seen', {
                            id: userId
                        });

                        // Scroll vers le bas
                        this.scrollToBottom();
                    } catch (error) {
                        console.error(error);
                    } finally {
                        this.loadingMessages = false;
                    }
                },

                async sendMessage() {
                    if (!this.newMessage.trim() && !this.fileToUpload) return;

                    const formData = new FormData();
                    formData.append('id', this.currentChat);
                    formData.append('message', this.newMessage);
                    formData.append('temporaryMsgId', Date.now());

                    console.log(formData);

                    if (this.fileToUpload) {
                        formData.append('attachment', this.fileToUpload);
                    }

                    try {
                        const response = await axios.post('/messenger/send-message', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });

                        // Ajouter le nouveau message
                        let messagesList = document.getElementById('messages-list');
                        messagesList.insertAdjacentHTML('beforeend', response.data.message);

                        // Réinitialiser
                        this.clearAttachment();
                        this.loadContacts();

                        // Scroll vers le bas
                        this.scrollToBottom();
                    } catch (error) {
                        console.error(error);
                        showToast('Erreur lors de l\'envoi du message', 'error');
                    }
                },

                async deleteMessage(messageId) {
                    try {
                        const response = await axios.delete('/messenger/delete-message', {
                            params: {
                                message_id: messageId
                            }
                        });

                        if (response.data.status === 'success') {
                            const messageElement = document.querySelector(`.message-card[data-id="${messageId}"]`);
                            if (messageElement) {
                                messageElement.remove();
                            }
                            showToast(response.data.message, 'success');
                        } else {
                            showToast('Erreur lors de la suppression du message', 'error');
                        }
                    } catch (error) {
                        console.error(error);
                    }
                },

                scrollToBottom() {
                    const container = document.getElementById('messages-container');
                    container.scrollTop = container.scrollHeight;
                },

                async toggleFavorite(userId) {
                    try {
                        const response = await axios.post('/messenger/favorite', {
                            id: userId
                        });

                        if (response.data.status === 'added') {
                            this.favorites.push({
                                id: userId,
                                pseudo: this.currentChatUser.pseudo,
                                avatar: this.currentChatUser.avatar
                            });
                        } else {
                            this.favorites = this.favorites.filter(fav => fav.id !== userId);
                        }
                    } catch (error) {
                        console.error(error);
                    }
                },

                isFavorite(userId) {
                    return this.favorites.some(fav => fav.id === userId);
                },

                startTyping() {
                    this.typing = true;
                    Echo.private(`chat.${this.currentChat}`)
                        .whisper('typing', {
                            userId: this.currentUser.id
                        });
                },
                stopTyping() {
                    this.typing = false;
                    // Envoyer un événement pour indiquer l'arrêt de la saisie
                },

                async loadMoreMessages() {
                    // Implémentez le chargement des messages plus anciens
                }

            }
        }

        // Fonction pour redimensionner automatiquement le textarea
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }

        // Fonction utilitaire
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
@endsection
