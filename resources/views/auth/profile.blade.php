@extends('layouts.base')
@php
    use Carbon\Carbon;
@endphp

@section('pageTitle')
    {{ __('profile.my_account') }}
@endsection

@section('content')
    <div x-data="{ couvertureForm: false }">
        <div class="relative max-h-[30vh] min-h-[30vh] w-full overflow-hidden font-roboto-slab"
            style="background: url({{ $user->couverture_image ? asset('storage/couvertures/' . $user->couverture_image) : asset('images/Logo_lg.png') }}) center center /cover;">
            <div x-on:click.stop="$dispatch('img-modal', {  imgModalSrc: '{{ $couverture_image = $user->couverture_image }}' ? '{{ asset('storage/couvertures/' . $couverture_image) }}' : '{{ asset('images/Logo_lg.png') }}', imgModalDesc: '' })"
                class="absolute inset-0"></div>
            <div class="absolute bottom-2 right-4">
                <button x-on:click.stop="couvertureForm = !couvertureForm"
                    class="hover:text-green-gs z-50 flex h-10 w-10 items-center justify-center rounded-full bg-white text-amber-500 shadow-md transition-colors hover:bg-gray-100"
                    data-tooltip-target="tooltip-cover-photo" data-tooltip-placement="top">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="#7F55B1"
                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                    </svg>
                </button>
                <div id="tooltip-cover-photo" role="tooltip"
                    class="font-roboto-slab tooltip invisible absolute z-10 inline-block whitespace-nowrap rounded-lg bg-supaGirlRosePastel px-2 py-1 text-xs font-roboto-slab text-textColor opacity-0 shadow-sm transition-opacity duration-300 ">
                    {{ __('profile.edit_cover_photo') }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <div x-cloak x-show="couvertureForm" x-transition.opacity.duration.300ms
                    x-trap.inert.noscroll="couvertureForm" x-on:keydown.esc.window="couvertureForm = false"
                    x-on:click.self="couvertureForm = false"
                    class="fixed inset-0 z-30 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
                    role="dialog" aria-modal="true" aria-labelledby="modal-title">
                    <!-- Modal Dialog -->
                    <div x-show="couvertureForm" x-data="imageViewer('')"
                        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="relative w-full max-w-md rounded-xl bg-white shadow-xl">
                        <!-- Close Button -->
                        <button type="button" x-on:click="couvertureForm = false"
                            class="absolute right-3 top-3 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">{{ __('profile.close') }}</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Modal Content -->
                        <div class="p-6">
                            <h3 id="modal-title" class="font-roboto-slab text-green-gs mb-6 text-center text-xl font-roboto-slab">
                                {{ __('profile.update_cover_photo') }}
                            </h3>

                            <form action="{{ route('profile.update-photo') }}" method="post" enctype="multipart/form-data"
                                class="space-y-6">
                                @csrf()

                                <!-- Image Preview -->
                                <div class="flex justify-center">
                                    <div
                                        class="relative h-40 w-40 overflow-hidden rounded-lg border-2 border-dashed   border-gray-300 font-roboto-slab bg-gray-50">
                                        <template x-if="!imageUrl">
                                            <div class="flex h-full flex-col items-center justify-center p-4 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span
                                                    class="mt-2 block text-sm text-gray-600">{{ __('profile.image_preview') }}</span>
                                            </div>
                                        </template>
                                        <template x-if="imageUrl">
                                            <img :src="imageUrl" class="h-full w-full object-cover"
                                                alt="Aperçu de l'image">
                                        </template>
                                    </div>
                                </div>

                                <!-- File Input -->
                                <div class="mt-4">
                                    <label
                                        class="flex cursor-pointer items-center justify-between rounded-lg border-2 border-dashed   border-gray-300 font-roboto-slab bg-white p-4 transition-colors hover:border-amber-500 hover:bg-amber-50">
                                        <div class="flex items-center">
                                            <svg class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <span class="ml-2 text-sm text-green-gs">
                                                <span
                                                    x-text="imageUrl ? '{{ __('profile.change_file') }}' : '{{ __('profile.select_file') }}'"></span>
                                                <span
                                                    class="block text-xs text-gray-500">{{ __('profile.file_types') }}</span>
                                            </span>
                                        </div>
                                        <input name="photo_couverture" type="file" accept="image/*"
                                            x-on:change="fileChosen($event)" class="hidden" required>
                                    </label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" x-on:click="couvertureForm = false"
                                        class="rounded-lg border   border-gray-300 font-roboto-slab bg-white px-4 py-2 text-sm font-roboto-slab text-green-gs shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                        {{ __('profile.cancel') }}
                                    </button>
                                    <button type="submit"
                                        class="btn-gs-gradient inline-flex items-center rounded-lg px-4 py-2 text-sm font-roboto-slab text-white shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                        <svg x-show="!imageUrl" class="-ml-0.5 mr-2 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span
                                            x-text="imageUrl ? '{{ __('profile.update') }}' : '{{ __('profile.upload') }}'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div x-data="{ pageSection: $persist('compte'), userType: '{{ $user->profile_type }}', completionPercentage: 0, dropdownData: '', storyForm: false, fetchCompletionPercentage() { fetch('/profile-completion-percentage').then(response => response.json()).then(data => { this.completionPercentage = data.percentage; }); }, fetchDropdownData() { fetch('/dropdown-data').then(response => response.json()).then(data => { this.dropdownData = data; }); } }" x-init="fetchCompletionPercentage()"
            class="container mx-auto flex flex-col justify-center xl:flex-row">

            {{-- Left section profile --}}
            <div x-data="{ profileForm: false }" class="min-w-1/4 flex flex-col items-center">


                <div class="relative -top-[12vh] h-[300px]">
                    <div class="w-55 h-55 border-5 mx-auto rounded-full border-white">
                        <img x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ $avatar = auth()->user()->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })"
                            class="h-full w-full rounded-full object-cover object-center"
                            @if ($avatar = auth()->user()->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                            @else
                            src="{{ asset('images/icon_logo.png') }}" @endif
                            alt="image profile" />

                        <div class="relative">
                            <button x-on:click="profileForm = true" type="button"
                                class="absolute bottom-2 right-4 flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-white shadow-md transition-colors hover:bg-gray-100"
                                data-tooltip-target="tooltip-profile-photo" data-tooltip-placement="top">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M15.275 12.475L11.525 8.7L14.3 5.95l-.725-.725L8.1 10.7L6.7 9.3l5.45-5.475q.6-.6 1.413-.6t1.412.6l.725.725l1.25-1.25q.3-.3.713-.3t.712.3L20.7 5.625q.3.3.3.713t-.3.712zM6.75 21H3v-3.75l7.1-7.125l3.775 3.75z" />
                                </svg>
                            </button>


                            <!-- Modal Backdrop -->
                            <div x-cloak x-show="profileForm" x-transition.opacity.duration.300ms
                                x-trap.inert.noscroll="profileForm" x-on:keydown.esc.window="profileForm = false"
                                x-on:click.self="profileForm = false"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
                                role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">

                                <!-- Modal Dialog -->
                                <div x-show="profileForm" x-data="imageViewer('')"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="relative w-full max-w-md rounded-xl bg-white shadow-xl">

                                    <!-- Close Button -->
                                    <button type="button" x-on:click="profileForm = false"
                                        class="absolute right-3 top-3 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                                        <span class="sr-only">{{ __('profile.close') }}</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <!-- Modal Content -->
                                    <div class="p-6">
                                        <h3 id="profile-modal-title"
                                            class="font-roboto-slab text-green-gs mb-6 text-center text-xl font-roboto-slab">
                                            {{ __('profile.edit_profile_photo') }}
                                        </h3>

                                        <form action="{{ route('profile.update-photo') }}" method="post"
                                            enctype="multipart/form-data" class="space-y-6">
                                            @csrf()

                                            <!-- Image Preview -->
                                            <div class="flex justify-center">
                                                <div
                                                    class="relative h-40 w-40 overflow-hidden rounded-full border-2 border-dashed   border-gray-300 font-roboto-slab bg-gray-50">
                                                    <template x-if="!imageUrl">
                                                        <div
                                                            class="flex h-full flex-col items-center justify-center p-4 text-center">
                                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            <span
                                                                class="mt-2 block text-sm text-gray-600">{{ __('profile.image_preview') }}</span>
                                                        </div>
                                                    </template>
                                                    <template x-if="imageUrl">
                                                        <img :src="imageUrl" class="h-full w-full object-cover"
                                                            alt="{{ __('profile.image_preview') }}">
                                                    </template>
                                                </div>
                                            </div>

                                            <!-- File Input -->
                                            <div class="mt-4">
                                                <label
                                                    class="flex cursor-pointer items-center justify-between rounded-lg border-2 border-dashed   border-gray-300 font-roboto-slab bg-white p-4 transition-colors hover:border-amber-500 hover:bg-amber-50">
                                                    <div class="flex items-center">
                                                        <svg class="h-6 w-6 text-amber-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                        </svg>
                                                        <span class="ml-2 text-sm text-green-gs">
                                                            <span
                                                                x-text="imageUrl ? '{{ __('profile.change_file') }}' : '{{ __('profile.select_file') }}'"></span>
                                                            <span
                                                                class="block text-xs text-gray-500">{{ __('profile.file_types') }}</span>
                                                        </span>
                                                    </div>
                                                    <input name="photo_profil" type="file" accept="image/*"
                                                        x-on:change="fileChosen($event)" class="hidden" required>
                                                </label>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="mt-6 flex justify-end space-x-3">
                                                <button type="button" x-on:click="profileForm = false"
                                                    class="rounded-lg border   border-gray-300 font-roboto-slab bg-white px-4 py-2 text-sm font-roboto-slab text-green-gs shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                    {{ __('profile.cancel') }}
                                                </button>
                                                <button type="submit"
                                                    class="btn-gs-gradient inline-flex items-center rounded-lg px-4 py-2 text-sm font-roboto-slab text-white shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                    <svg x-show="!imageUrl" class="-ml-0.5 mr-2 h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                    </svg>
                                                    <span
                                                        x-text="imageUrl ? '{{ __('profile.update') }}' : '{{ __('profile.upload') }}'"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




                            <div id="tooltip-profile-photo" role="tooltip"
                                class="tooltip invisible absolute z-10 inline-block whitespace-nowrap rounded-lg bg-green-gs px-2 py-1 text-xs font-roboto-slab text-white opacity-0 shadow-sm transition-opacity duration-300   ">
                                {{ __('profile.edit_profile_photo') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>

                    <div class='mt-6 flex w-full flex-col items-center'>

                        <p class="mb-4 text-center text-xl font-bold text-textColor font-roboto-slab">
                            {{ $user->prenom ?? ($user->pseudo ?? $user->nom_salon) }}
                        </p>
                        <div class="text-green-gs flex w-full items-center justify-around gap-2">

                            <div class="flex items-center gap-3 rounded-lg p-2 transition-colors hover:bg-green-50/30">
                                <svg class="text-green-gs h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 22 22" fill="none">
                                    <path
                                        d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <span
                                    class="text-textColorParagraph font-roboto-slab">{{ $user->canton['nom'] ?? __('profile.not_specified') }}</span>
                            </div>

                            <a href="tel:{{ $user->telephone }}"
                                class="flex items-center gap-3 rounded-lg p-2 transition-colors hover:bg-green-50/30">
                                <svg class="text-green-gs h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21z" />
                                </svg>
                                <span class="text-textColorParagraph font-roboto-slab">{{ $user->telephone ?? __('profile.not_specified') }}</span>
                            </a>

                        </div>

                        @if ($user->profile_type == 'salon')
                            <div class="mt-2 border-t border-supaGirlRosePastel pt-4">
                                <div class="flex items-center gap-3 rounded-lg bg-fieldBg p-2">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                        <path fill="none" stroke="#FDA5D6" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M24 43.5c9.043-3.117 15.488-10.363 16.5-19.589c.28-4.005.256-8.025-.072-12.027a2.54 2.54 0 0 0-2.467-2.366c-4.091-.126-8.846-.808-12.52-4.427a2.05 2.05 0 0 0-2.881 0c-3.675 3.619-8.43 4.301-12.52 4.427a2.54 2.54 0 0 0-2.468 2.366A79.4 79.4 0 0 0 7.5 23.911C8.51 33.137 14.957 40.383 24 43.5" />
                                        <circle cx="24" cy="20.206" r="4.299" fill="none"
                                            stroke="#FDA5D6" stroke-linecap="round" stroke-linejoin="round" />
                                        <path fill="none" stroke="#FDA5D6" stroke-linecap="round"
                                            stroke-linejoin="round" d="M31.589 32.093a7.589 7.589 0 1 0-15.178 0" />
                                    </svg>
                                    <div>
                                        <span class="font-roboto-slab text-green-gs font-roboto-slab">{{ __('profile.recruitment') }} :</span>
                                        
                                         
                                            @if ($user->recrutement == 'Ouvert')
                                                <span
                                            class="ml-1 text-supGirlRose font-roboto-slab">{{ __('salon_profile.open') }}</span>
                                            @else
                                                <span
                                            class="ml-1 text-textColorParagraph font-roboto-slab">{{ __('salon_profile.closed')}}</span>
                                            @endif
                                       
                                                            
                                    
                                        </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
                
                <hr class="h-2 w-full text-green-gs">

                <button data-modal-target="addInfoProf" data-modal-toggle="addInfoProf"
                    class="text-green-gs hover:bg-green-gs mx-2 my-2 w-[90%] cursor-pointer rounded-lg border border-supaGirlRose p-2 text-sm hover:text-white font-roboto-slab">
                    {{ __('profile.profile_improvement') }}
                </button>
                <a href="{{ route('profile.visibility.update') }}"
                    class="text-green-gs hover:bg-green-gs w-[90%] cursor-pointer rounded-lg border border-supaGirlRose p-2 text-center text-sm hover:text-white font-roboto-slab">
                    {{ __('profile.profile_visibility') }}
                </a>
                @if ($user->profile_type === 'escorte')
                    <x-gestion-invitation :user="$user" :invitations-recus="$invitationsRecus" :list-invitation-salons="$listInvitationSalons" :salon-associers="$salonAssociers" />
                @elseif ($user->profile_type === 'salon')
                    <x-gestion-invitation :user="$user" :invitations-recus="$invitationsRecus" :list-invitation-salons="$listInvitation" :salon-associers="$salonAssociers" />
                @endif

                <div class="mb-5 mt-2 flex w-full flex-col items-center gap-0">
                    <button x-on:click="pageSection='compte'"
                        :class="pageSection == 'compte' ? 'bg-green-gs text-white rounded-md' : ''"
                        class="text-green-gs hover:bg-green-gs w-[90%] cursor-pointer border-b border-gray-400 p-2 text-left font-bold hover:text-white font-roboto-slab">{{ __('profile.my_account') }}</button>
                    <button x-show="userType == 'invite'" x-on:click="pageSection='favoris'"
                        :class="pageSection == 'favoris' ? 'bg-green-gs text-white rounded-md' : ''"
                        class="text-green-gs hover:bg-green-gs w-[90%] cursor-pointer border-b border-gray-400 p-2 text-left font-bold hover:text-white font-roboto-slab">{{ __('profile.my_favorites') }}</button>
                    <button x-show="userType != 'invite'" x-on:click="pageSection='galerie'"
                        :class="pageSection == 'galerie' ? 'bg-green-gs text-white rounded-md' : ''"
                        class="text-green-gs hover:bg-green-gs w-[90%] cursor-pointer border-b border-gray-400 p-2 text-left font-bold hover:text-white font-roboto-slab">{{ __('profile.gallery') }}</button>
                    <button x-on:click="pageSection='discussion'"
                        :class="pageSection == 'discussion' ? 'bg-green-gs text-white rounded-md' : ''"
                        class="text-green-gs hover:bg-green-gs flex w-[90%] cursor-pointer items-center border-b border-gray-400 p-2 text-left font-bold hover:text-white font-roboto-slab">{{ __('profile.discussion') }}
                        @if ($messageNoSeen > 0)
                            <span
                                class="ms-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-red-200 text-xs font-semibold text-red-800 font-roboto-slab">{{ $messageNoSeen }}</span>
                        @endif
                    </button>
                    @if ($allrelation->isNotEmpty())
                        <x-gestion-escorte-creer :allrelation="$allrelation" />
                    @endif
                </div>
            </div>

            {{-- Modale pour l'amelioration du profile --}}
            <div x-data="multiStepForm()" x-init="fetchDropdownData();" id="addInfoProf" tabindex="-1" aria-hidden="true"
                class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
                <!-- Modale -->
                <div class="max-h-[90vh] w-[90vw] overflow-y-auto rounded-lg bg-white p-6 shadow-lg xl:max-w-7xl">
                    <!-- Étapes -->
                    <div class="mb-6 flex w-full justify-between gap-5">
                        <template class="w-full" x-for="(step, index) in steps" :key="index">
                            <div :class="index < steps.length - 1 ? 'w-full' : 'w-auto xl:w-full'"
                                class="flex items-center justify-start">
                                <div x-on:click="currentStep=index"
                                    class="mx-2 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full"
                                    :class="{
                                        'bg-amber-400 text-white': index < currentStep,
                                        'bg-blue-500 text-white animate-bounce': index === currentStep,
                                        'bg-gray-300 text-gray-600': index > currentStep
                                    }">
                                    <span x-text="index + 1"></span>
                                </div>
                                <span class="hidden xl:block" :class="{ 'text-amber-400': index < currentStep }"
                                    x-text="step"></span>
                                <span :class="index < steps.length - 1 ? 'flex' : 'hidden'"
                                    class="h-1 w-16 flex-1 bg-gray-300 md:mx-1"></span>
                            </div>
                        </template>
                    </div>

                    <div class="w-full rounded-full bg-gray-200   ">
                        <div class="rounded-full bg-amber-600 p-0.5 text-center text-xs font-roboto-slab leading-none text-amber-100"
                            :style="`width: ${completionPercentage}%`" x-text=`${completionPercentage}%`></div>
                    </div>

                    <!-- Contenu du formulaire -->
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf

                        <!-- Étape 1: Informations personnelles -->
                        <div x-data="{ cantons: {{ $cantons }}, selectedCanton: {{ $user->canton?->id ?? 1 }}, villes: {{ $villes }}, availableVilles: {{ $villes }} }" x-show="currentStep === 0">
                            <div class="mb-4 mt-4">
                                <input type="hidden" name="lang" value="{{ app()->getLocale() }}">
                                @if ($user->profile_type !== 'salon')
                                <label class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.genre') }}</label>
                                <div class="flex">
                                    <div id="states-button" data-dropdown-toggle="dropdown-states"
                                        class="z-10 inline-flex shrink-0 items-center rounded-s-lg border border-e-0   border-gray-300 font-roboto-slab bg-gray-50 px-4 py-2.5 text-center text-sm font-roboto-slab text-gray-500 focus:outline-none        "
                                        type="button">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                            <path fill="currentColor"
                                                d="M208 20h-40a12 12 0 0 0 0 24h11l-15.64 15.67A68 68 0 1 0 108 178.92V192H88a12 12 0 0 0 0 24h20v16a12 12 0 0 0 24 0v-16h20a12 12 0 0 0 0-24h-20v-13.08a67.93 67.93 0 0 0 46.9-100.84L196 61v11a12 12 0 0 0 24 0V32a12 12 0 0 0-12-12m-88 136a44 44 0 1 1 44-44a44.05 44.05 0 0 1-44 44" />
                                        </svg>
                                    </div>
                                    
                                    <select name="genre_id" id="genre_id"
                                        class="block w-full rounded-e-lg border border-s-0   border-gray-300 font-roboto-slab border-s-gray-100 bg-gray-50 p-2.5 ps-2 text-sm text-green-gs            ">
                                        <option hidden value=""> -- </option>
                                        @foreach ($genres as $genre)
                                            <option value="{{ $genre->id }}"
                                                @if ($user->genre_id === $genre->id) selected @endif>
                                                {{ $genre->getTranslation('name', app()->getLocale()) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                           
                            @if ($user->profile_type == 'salon')
                            @php
                                    $intituledata = ['madame', 'monsieur', 'mademoiselle', 'autre'];
                                    @endphp

  
                                <x-form.select
                                name="intitule"
                                :label="__('salon_register_form.title')"
                                :selected="$user->intitule ?? null"
                            >
                                <option value="">--</option>
                                @foreach ($intituledata as $intitule)
                                            <option value={{ $intitule }}
                                                @if ($user->intitule ? $user->intitule == $intitule : false) selected @endif>{{ __('salon_register_form.' . $intitule) }}
                                            </option>
                                        @endforeach
                            </x-form.select>

                                <x-form.input 
                                name="nom_proprietaire"
                                :label="__('profile.owner_name')"
                                :value="$user->nom_proprietaire"
                                input-class="text-textColorParagraph border-supaGirlRosePastel/50"
                            />

                             














                            @endif
                            @if ($user->profile_type == 'escorte')
                                <div class="mb-4">
                                    <label
                                        class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.name') }}</label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 start-0 top-0 flex items-center ps-3.5">
                                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 6t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
                                            </svg>
                                        </div>
                                        <input type="text" id="name" name="prenom"
                                            aria-describedby="helper-text-explanation"
                                            class="block w-full rounded-lg border   border-gray-300 font-roboto-slab bg-gray-50 p-2.5 ps-10 text-sm text-green-gs focus:border-blue-500 focus:ring-blue-500            dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            value="{{ $user->prenom }}" />
                                    </div>
                                </div>
                            @endif
                            @if ($user->profile_type == 'invite')
                                <div class="mb-4">
                                    <label
                                        class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.pseudo') }}</label>
                                    <input type="text" name="pseudo"
                                        class="mt-1 block w-full rounded-md   border-gray-300 font-roboto-slab shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ $user->pseudo }}">
                                </div>
                            @endif
                            <div class="mb-4">
                                <label class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.email') }}</label>
                                <div class="relative">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 start-0 top-0 flex items-center ps-3.5">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12v1.45q0 1.475-1.012 2.513T18.5 17q-.875 0-1.65-.375t-1.3-1.075q-.725.725-1.638 1.088T12 17q-2.075 0-3.537-1.463T7 12t1.463-3.537T12 7t3.538 1.463T17 12v1.45q0 .65.425 1.1T18.5 15t1.075-.45t.425-1.1V12q0-3.35-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20h4q.425 0 .713.288T17 21t-.288.713T16 22zm0-7q1.25 0 2.125-.875T15 12t-.875-2.125T12 9t-2.125.875T9 12t.875 2.125T12 15m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email"
                                        aria-describedby="helper-text-explanation"
                                        class="block w-full rounded-lg border   border-gray-300 font-roboto-slab bg-gray-50 p-2.5 ps-10 text-sm text-green-gs focus:border-blue-500 focus:ring-blue-500            dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        value="{{ $user->email }}" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.phone_number') }}</label>
                                <div class="relative">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 start-0 top-0 flex items-center ps-3.5">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                                            <path
                                                d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="phone-input" name="telephone"
                                        aria-describedby="helper-text-explanation"
                                        class="block w-full rounded-lg border   border-gray-300 font-roboto-slab bg-gray-50 p-2.5 ps-10 text-sm text-green-gs focus:border-blue-500 focus:ring-blue-500            dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        value="{{ $user->telephone }}" />
                                </div>
                            </div>
                            <x-form.input 
                                name="adresse"
                                :label="__('profile.address')"
                                :value="$user->adresse"
                                input-class="text-textColorParagraph border-supaGirlRosePastel/50"
                            />
                            <x-form.input 
                                name="npa"
                                :label="__('profile.npa')"
                                :value="$user->npa"
                                input-class="text-textColorParagraph border-supaGirlRosePastel/50"
                            />
                           
                            <x-form.location-select
                                :cantons="$cantons"
                                :villes="$villes"
                                :selectedCanton="$user->canton['id'] ?? null"
                                :selectedVille="$user->ville"
                                :cantonLabel="__('profile.canton')"
                                :villeLabel="__('profile.city')"
                                required
                                class="space-y-4"
                            />
                        </div>

                        <!-- Étape 2: Informations professionnelles -->
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 pt-4" :class="userType == 'invite' ? 'hidden' : ''"
                            x-show="currentStep === 1">
                            @if ($user->profile_type == 'salon')
                                <x-form.select-field
                                    name="categorie"
                                    :label="__('profile.category')"
                                    :options="$salon_categories"
                                    option-value="id"
                                    option-label="nom"
                                    :selected="$user->categorie['id'] ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />


                                @php
                                    $recrutements = [
                                        ['id' => 'Ouvert', 'nom' => __('profile.recruitment_open')],
                                        ['id' => 'Fermé', 'nom' => __('profile.recruitment_closed')],
                                    ];
                                @endphp

                                <x-form.select-field
                                    name="recrutement"
                                    :label="__('profile.recruitment')"
                                    :options="$recrutements"
                                    option-value="id"
                                    option-label="nom"
                                    :selected="$user->recrutement ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />

                                <x-form.select-field
                                    name="nombre_fille_id"
                                    :label="__('profile.number_of_girls')"
                                    :options="$nombre_filles"
                                    option-value="id"
                                    option-label="name"
                                    :translatable="true"
                                    translation-key="name"
                                    :selected="$user->nombre_fille_id"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                >
                                    <option hidden value=""> -- </option>
                                </x-form.select-field>
                            @endif
                            <!-- ESCORTE -->
                            @if ($user->profile_type == 'escorte')

                            <x-form.select-field
                                    name="categorie"
                                    :label="__('profile.category')"
                                    :options="$escort_categories"
                                    option-value="id"
                                    option-label="nom"
                                    :selected="$user->categorie['id'] ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />

                                <x-form.select-field
                                    name="pratique_sexuelle_id"
                                    :label="__('profile.sexual_practices')"
                                    :options="$pratiquesSexuelles"
                                    option-value="id"
                                    option-label="name"
                                    :translatable="true"
                                    translation-key="name"
                                    :selected="$user->pratique_sexuelle_id"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                >
                                    <option hidden value=""> -- </option>
                                </x-form.select-field>


                                <x-form.select-field
                                    name="orientation_sexuelle_id"
                                    :label="__('profile.sexual_orientation')"
                                    :options="$oriantationSexuelles"
                                    option-value="id"
                                    option-label="name"
                                    :translatable="true"
                                    translation-key="name"
                                    :selected="$user->orientation_sexuelle_id"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                >
                                    <option hidden value=""> -- </option>
                                </x-form.select-field>

                                
                                <div class="col-span-2 mb-4 md:col-span-1">
                                    <label
                                        class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.services') }}</label>
                                    <x-select_object_multiple name="service" :options="$services" :value="$user->service"
                                        label="Mes services" />
                                </div>

                                <x-form.input 
                                name="tailles"
                                :label="__('profile.height')"
                                :value="$user->tailles"
                                input-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                type="number"
                                />

                                <x-form.select-field
                                    name="origine"
                                    :label="__('profile.origin')"
                                    :options="$origines"
                                    option-value="id"
                                    option-label="nom"
                                    :selected="$user->origine ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />

                            


                                <x-form.select-field
                                    name="couleur_yeux_id"
                                    :label="__('profile.eye_color')"
                                    :options="$couleursYeux"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->couleur_yeux_id ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />


                                <x-form.select-field
                                    name="couleur_cheveux_id"
                                    :label="__('profile.hair_color')"
                                    :options="$couleursCheveux"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->couleur_cheveux_id ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />


                               
                                <x-form.select-field
                                    name="mensuration_id"
                                    :label="__('profile.measurements')"
                                    :options="$mensurations"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->mensuration_id ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />
                                
                                
                                <x-form.select-field
                                    name="poitrine_id"
                                    :label="__('profile.bust')"
                                    :options="$poitrines"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->poitrine_id ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />
                                
                                
                                <x-form.select-field
                                    name="taille_poitrine"
                                    :label="__('profile.bust_size')"
                                    :options="$taillesPoitrine"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->taille_poitrine ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />
                                
                               
                                <x-form.select-field
                                    name="pubis_type_id"
                                    :label="__('profile.pubic_hair')"
                                    :options="$pubis"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->pubis_type_id ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />
                                
                              
                                <x-form.select-field
                                    name="tatoo_id"
                                    :label="__('profile.tattoos')"
                                    :options="$tatouages"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->tatoo_id ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />
                                
                              
                                
                                
                                <x-form.select-field
                                    name="mobilite_id"
                                    :label="__('profile.mobility')"
                                    :options="$mobilites"
                                    option-value="id"
                                    option-label="name"
                                    :selected="$user->mobilite_id ?? null"
                                    required
                                    container-class="col-span-2 mb-4 md:col-span-1"
                                    select-class="text-textColorParagraph border-supaGirlRosePastel/50"
                                />
                                
                                
                                
                            @endif

                           
                            <div class="col-span-2 mb-4 md:col-span-1">
                                <label
                                    class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.language') }}</label>
                                <x-select_multiple name="langues" :options="$langues" :value="explode(',', $user->langues)"
                                    label="Langue parler" />
                            </div>

                    
                            <div class="col-span-2 mb-4 md:col-span-1">
                                <label class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.rate') }}</label>
                                <select id="tarif" name="tarif"
                                    class="mt-1 block w-full rounded-md text-textColorParagraph border-supaGirlRosePastel/50 font-roboto-slab shadow-sm">
                                    <option hidden value=""> -- </option>
                                    @foreach ($tarifs as $tarif)
                                        <option value="{{ $tarif }}" {{ $user->tarif == $tarif ? 'selected' : '' }}>
                                            {{ __('profile.price_from', ['price' => $tarif]) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>






                            <div class="col-span-2 mb-4 md:col-span-1">
                                <label
                                    class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.payment_method') }}</label>
                                <x-select_multiple name="paiement" :options="$paiements" :value="explode(',', $user->paiement)"
                                    label="Paiment" />
                            </div>
                            <div class="col-span-2 mb-4">
                                <label class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.about') }}</label>
                                <textarea rows="4" name="apropos"
                                    class="block w-full rounded-lg border   border-supaGirlRosePastel/50 font-roboto-slab bg-gray-50 text-sm text-textColorParagraph focus:border-supaGirlRosePastel/50 focus:ring-supaGirlRosePastel/50">{{ $user->apropos ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Étape 3: Informations complémentaires -->
                        <div class="pt-4"
                            @if ($user->profile_type == 'invite') x-show="currentStep === 1" @else x-show="currentStep === 2" @endif>
                            <x-form.input 
                                name="autre_contact"
                                :label="__('profile.other_contact')"
                                :value="$user->autre_contact"
                                input-class="text-textColorParagraph border-supaGirlRosePastel/50"
                            />
                            
                            <x-form.input 
                                name="complement_adresse"
                                :label="__('profile.address_complement')"
                                :value="$user->complement_adresse"
                                input-class="text-textColorParagraph border-supaGirlRosePastel/50"
                            />
                            
                           
                            
                            <x-form.input 
                                name="lien_site_web"
                                :label="__('profile.website_link')"
                                :value="$user->lien_site_web"
                                input-class="text-textColorParagraph border-supaGirlRosePastel/50"
                            />
                            
                           
                            <x-location-selector user='{{ $user->id }}' />

                        </div>

                        <!-- Boutons de navigation -->
                        <div class="mt-6 flex justify-between gap-2 text-sm md:text-base">
                            <button type="button" @click="prevStep"
                                class="rounded-md bg-gray-300 px-4 py-2 text-green-gs font-roboto-slab" x-show="currentStep > 0">
                                {{ __('profile.previous') }}
                            </button>
                            <button type="button" @click="saveAndQuit"
                                class="rounded-md bg-green-gs text-white px-4 py-2 font-roboto-slab"
                                x-show="currentStep < steps.length - 1">
                                {{ __('profile.save_and_quit') }}
                            </button>
                            <button type="button" @click="nextStep" class="rounded-md bg-supaGirlRosePastel text-green-gs px-4 py-2 font-roboto-slab"
                                x-show="currentStep < steps.length - 1">
                                {{ __('profile.next') }}
                            </button>
                            <button id="addInfoSubmit" type="submit"
                                class="rounded-md bg-green-gs text-white px-4 py-2 font-roboto-slab"
                                x-show="currentStep === steps.length - 1">
                                {{ __('profile.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal edit service --}}
            <div id="editServiceModal" tabindex="-1" aria-hidden="true"
                class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
                <!-- Modale -->
                <div class="max-h-[90vh] min-h-[35vh] w-[90vw] overflow-y-auto rounded-lg bg-white p-6 shadow-lg xl:max-w-7xl">
                    <form action="{{ route('profile.edit-service') }}" method="post" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        <div class="col-span-2 mb-4 md:col-span-1">
                            <label
                                class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.category') }}</label>
                            <select name="categorie" id="escort_categorie"
                                class="mt-1 block w-full rounded-md   border-gray-300 font-roboto-slab shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option hidden value=""> -- </option>
                                @foreach ($escort_categories as $categorie)
                                    <option value={{ $categorie['id'] }}
                                        @if ($user->categorie ? $user->categorie['id'] == $categorie->id : false) selected @endif>{{ $categorie['nom'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 mb-4 md:col-span-1">
                            <label
                                class="block text-sm font-roboto-slab text-green-gs">{{ __('profile.services') }}</label>
                            <x-select_object_multiple name="service" :options="$services" :value="$user->service"
                                label="Mes services" />
                        </div>
                        <button type="submit"
                            class="btn-gs-gradient inline-flex items-center rounded-lg px-4 py-2 text-sm font-bold text-black shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50">
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ __('profile.submit') }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Right section profile --}}
            <div class="min-w-3/4 flex flex-col gap-5 px-5 py-5">



                {{-- Message --}}
                <div x-data="{ isOpen: window.innerWidth >= 768 }" x-show="completionPercentage != 100"
                    @resize.window="isOpen = window.innerWidth >= 768"
                    class="mb-4 overflow-hidden rounded-lg bg-red-50 p-4 text-sm text-red-800" role="alert">

                    <!-- Header de l'accordéon (toujours visible sur mobile) -->
                    <button @click="isOpen = !isOpen"
                        class="flex w-full items-center justify-between p-4 text-left md:hidden">
                        <div class="flex items-center">
                            <svg class="me-3 h-4 w-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="font-bold">{{ __('profile.profile_completion') }} <span
                                    x-text="`${completionPercentage}%`"></span></span>
                        </div>
                        <svg x-show="!isOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <svg x-show="isOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                        </svg>
                    </button>

                    <!-- Contenu de l'alerte -->
                    <div x-show="isOpen" x-collapse class="md:flex md:items-start">
                        <!-- Icône (cachée sur mobile, visible sur desktop) -->
                        <svg class="me-3 mt-[2px] hidden h-4 w-4 shrink-0 md:inline" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>

                        <div class="text-dm-serif w-full">
                            <!-- Titre (caché sur mobile, visible sur desktop) -->
                            <span class="hidden font-bold md:inline font-roboto-slab">
                                {{ __('profile.profile_completion') }} <span x-text="`${completionPercentage}%`"></span>
                            </span>

                            <div class="my-1.5 font-roboto-slab">
                                {{ __('profile.profile_completion_message') }}
                                <a class="font-bold hover:underline" 
                                href="{{ route('static.page', 'pdc') }}"
                                >
                                    {{ __('profile.privacy_policy') }}
                                </a>
                            </div>

                            <button data-modal-target="addInfoProf" data-modal-toggle="addInfoProf"
                                class="font-roboto-slab text-green-gs hover:bg-green-gs mt-2 w-full rounded-lg border border-supaGirlRose px-4 py-2 text-center font-bold transition-all hover:text-white md:w-auto md:px-2 md:py-1">
                                {{ __('profile.improve_profile') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Invitation --}}
                @if ($user->profile_type === 'escorte' || $user->profile_type === 'salon')
                    <x-invitation-list :invitationsRecus="$invitationsRecus" type='{{ $user->profile_type }}' />
                @endif

                {{-- Pour invité --}}
                <div x-show="userType=='invite'">

                    <section x-show="pageSection=='compte'">

                        <div class="flex items-center justify-between py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('profile.my_information') }}</h2>
                        </div>
                        <div class="grid grid-cols-2 items-center gap-10 md:grid-cols-4">
                            <x-profile.info-item 
                                :value="$user->prenom ?? ($user->nom_salon ?? ($user->pseudo ?? __('profile.undefined')))"
                                icon-view-box="0 0 24 24"
                                icon-path="M5.85 17.1q1.275-.975 2.85-1.537T12 15t3.3.563t2.85 1.537q.875-1.025 1.363-2.325T20 12q0-3.325-2.337-5.663T12 4T6.337 6.338T4 12q0 1.475.488 2.775T5.85 17.1M12 13q-1.475 0-2.488-1.012T8.5 9.5t1.013-2.488T12 6t2.488 1.013T15.5 9.5t-1.012 2.488T12 13m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22"
                            />

                            <x-profile.info-item>
                                {{ Carbon::parse($user->date_naissance)->age }} {{ __('profile.years_old') }}
                                <x-slot name="icon">
                                    <svg class="h-5 w-5 text-supaGirlRose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10s10-4.5 10-10S17.5 2 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m.5-13H11v6l5.2 3.2l.8-1.3l-4.5-2.7V7z" />
                                    </svg>
                                </x-slot>
                            </x-profile.info-item>

                            <x-profile.info-item 
                                :value="$user->genre ? $user->genre->getTranslation('name', app()->getLocale()) : __('profile.undefined')"
                                icon-view-box="0 0 256 256"
                                icon-path="M208 20h-40a12 12 0 0 0 0 24h11l-15.64 15.67A68 68 0 1 0 108 178.92V192H88a12 12 0 0 0 0 24h20v16a12 12 0 0 0 24 0v-16h20a12 12 0 0 0 0-24h-20v-13.08a67.93 67.93 0 0 0 46.9-100.84L196 61v11a12 12 0 0 0 24 0V32a12 12 0 0 0-12-12m-88 136a44 44 0 1 1 44-44a44.05 44.05 0 0 1-44 44"
                            />

                            <x-profile.info-item>
                                {{ $user->canton->nom ?? $user->cantonget->nom ?? __('profile.undefined') }} -
                                {{ $user->ville->nom ?? $user->villeget->nom ?? __('profile.undefined') }}
                                <x-slot name="icon">
                                    <svg class="h-5 w-5 text-supaGirlRose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M4.35 20.7q-.5.2-.925-.112T3 19.75v-14q0-.325.188-.575T3.7 4.8L9 3l6 2.1l4.65-1.8q.5-.2.925.113T21 4.25v8.425q-.875-1.275-2.187-1.975T16 10q-.5 0-1 .088t-1 .262v-3.5l-4-1.4v13.075zM20.6 22l-2.55-2.55q-.45.275-.962.413T16 20q-1.65 0-2.825-1.175T12 16t1.175-2.825T16 12t2.825 1.175T20 16q0 .575-.137 1.088t-.413.962L22 20.6zM16 18q.85 0 1.413-.5T18 16q.025-.85-.562-1.425T16 14t-1.425.575T14 16t.575 1.425T16 18"/>
                                    </svg>
                                </x-slot>
                            </x-profile.info-item>
                        </div>

                        <div class="flex items-center justify-center py-5 md:justify-start">
                            <h2 class="text-2xl font-bold font-roboto-slab text-green-gs">{{ __('profile.my_favorites') }}</h2>
                        </div>
                        <div class="grid w-full grid-cols-1 gap-3 xl:grid-cols-2">
                            <div class="flex min-w-full flex-col items-center justify-center gap-4 xl:w-1/2">
                                <h3 class="font-roboto-slab text-green-gs text-xl">{{ __('profile.favorite_escorts') }}</h3>
                                @if ($escortFavorites != '[]')
                                    <div
                                        class="mb-4 grid w-full grid-cols-1 items-center gap-2 md:grid-cols-1 2xl:grid-cols-2">
                                        @foreach ($escortFavorites as $favorie)
                                            <livewire:escort-card name="{{ $favorie->prenom }}"
                                                canton="{{ $favorie->canton['nom'] ?? '' }}"
                                                ville="{{ $favorie->ville['nom'] ?? '' }}"
                                                avatar='{{ $favorie->avatar }}' isOnline='{{ $favorie->isOnline() }}'
                                                escortId="{{ $favorie->id }}" />
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-roboto-slab text-sm text-textColorParagraph">{{ __('profile.no_favorite_escorts') }}</div>
                                @endif
                            </div>
                            <div class="flex min-w-full flex-col items-center justify-center gap-4 xl:w-1/2">
                                <h3 class="font-roboto-slab text-green-gs text-xl">{{ __('profile.favorite_salons') }}</h3>
                                @if ($salonFavorites != '[]')
                                    <div
                                        class="mb-4 grid w-full grid-cols-1 items-center gap-2 md:grid-cols-1 2xl:grid-cols-2">
                                        @foreach ($salonFavorites as $favorie)
                                            <livewire:escort-card name="{{ $favorie->prenom }}"
                                                canton="{{ $favorie->canton['nom'] }}"
                                                ville="{{ $favorie->ville['nom'] }}" avatar='{{ $favorie->avatar }}'
                                                escortId="{{ $favorie->id }}" />
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-roboto-slab text-sm text-textColorParagraph">{{ __('profile.no_favorite_salons') }}</div>
                                @endif
                            </div>
                        </div>
                        @if ($user && $user->id)
                            <div>
                                <livewire:approximate userId="{{ $user->id }}" />
                            </div>
                        @endif

                    </section>

                    <section x-show="pageSection=='favoris'">
                        <div class="flex items-center gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('profile.my_favorites') }}</h2>
                            <div class="bg-green-gs h-1 w-full flex-1"></div>
                        </div>
                        <div class="grid w-full grid-cols-1">
                            <div class="relative flex min-w-full flex-col items-center justify-center gap-5 xl:w-1/2">
                                <h3 class="font-roboto-slab text-green-gs text-xl">{{ __('profile.favorite_escorts') }}</h3>
                                @if ($escortFavorites != '[]')
                                    <div id="NewEscortContainer"
                                        class="mb-4 mt-5 flex w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto px-5"
                                        style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                                        @foreach ($escortFavorites as $escort)
                                            <livewire:escort-card name="{{ $escort->prenom }}"
                                                canton="{{ $escort->canton['nom'] ?? '' }}"
                                                ville="{{ $escort->ville['nom'] ?? '' }}"
                                                avatar='{{ $escort->avatar }}' isOnline='{{ $escort->isOnline() }}'
                                                escortId='{{ $escort->id }}' />
                                        @endforeach
                                    </div>
                                    <div id="arrowEscortScrollRight"
                                        class="absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow 2xl:hidden"
                                        data-carousel-prev>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                                        </svg>
                                    </div>
                                    <div id="arrowEscortScrollLeft"
                                        class="absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow 2xl:hidden"
                                        data-carousel-next>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                                        </svg>
                                    </div>
                                @else
                                    <div>{{ __('profile.no_favorite_escorts') }}</div>
                                @endif
                            </div>
                            <div class="flex min-w-full flex-col items-center justify-center gap-5 xl:w-1/2">
                                <h3 class="font-roboto-slab text-green-gs text-xl">{{ __('profile.favorite_salons') }}</h3>
                                @if ($salonFavorites != '[]')
                                    <div id="NewEscortContainer"
                                        class="mb-4 mt-5 flex w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto px-5"
                                        style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                                        @foreach ($salonFavorites as $escort)
                                            <livewire:escort-card name="{{ $escort->prenom }}"
                                                canton="{{ $escort->canton['nom'] ?? '' }}"
                                                ville="{{ $escort->ville['nom'] ?? '' }}"
                                                avatar='{{ $escort->avatar }}' escortId='{{ $escort->id }}'
                                                isOnline='{{ $escort->isOnline() }}' />
                                        @endforeach
                                    </div>
                                    <div id="arrowEscortScrollRight"
                                        class="absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow 2xl:hidden"
                                        data-carousel-prev>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                                        </svg>
                                    </div>
                                    <div id="arrowEscortScrollLeft"
                                        class="absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow 2xl:hidden"
                                        data-carousel-next>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                                        </svg>
                                    </div>
                                @else
                                    <div>{{ __('profile.no_favorite_salons') }}</div>
                                @endif
                            </div>
                        </div>
                    </section>

                </div>


                {{-- Pour escort --}}
                <div x-show="userType=='escorte'">

                    {{-- Pour la vérification --}}
                    @if ($user->profile_verifie === 'verifier')
                        <div
                            class="border-blue-gs font-roboto-slab text-blue-gs flex w-full items-center justify-between rounded-xl border p-5">
                            <p class="flex items-center">
                                <i class="fas fa-check-circle text-blue-gs mr-2"></i>
                                {{ __('profile.profile_verified') }}
                            </p>
                        </div>
                    @elseif($user->profile_verifie === 'non verifier')
                        <div
                            class="border-green-gs font-roboto-slab text-green-gs flex w-full items-center justify-between rounded-xl border p-5">
                            <p>{{ __('profile.profile_not_verified') }}</p>
                            <button data-modal-target="requestModal" data-modal-toggle="requestModal"
                                class="bg-green-gs font-roboto-slab text-white px-5 py-2 hover:bg-fieldBg hover:text-green-gs">
                                {{ __('profile.send_request') }}
                            </button>
                        </div>
                    @elseif($user->profile_verifie === 'en cours')
                        <div
                            class="border-green-gs font-roboto-slab text-green-gs flex w-full items-center justify-between rounded-xl border p-5">
                            <p>{{ __('profile.profile_under_review') }}</p>
                        </div>
                    @endif


                    <!-- Modal Structure -->
                    <div id="requestModal" tabindex="-1" aria-hidden="true"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm transition-opacity duration-300"
                        data-modal-placement="center">
                        <div class="relative w-full max-w-md">
                            <!-- Modal content -->
                            <div class="relative rounded-xl bg-white p-6 shadow-2xl">
                                <!-- Close button -->
                                <button type="button"
                                    class="absolute right-4 top-4 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-green-gs"
                                    data-modal-hide="requestModal">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="sr-only">Fermer</span>
                                </button>

                                <!-- Header -->
                                <div class="mb-6 text-center">
                                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="mb-2 text-xl font-bold text-green-gs">
                                        {{ __('profile.send_verification_photo') }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ __('profile.verification_photo_instructions') }}
                                    </p>
                                </div>

                                <!-- Form -->
                                <div x-data="imageViewer('')" class="space-y-4">
                                    <form action="{{ route('profile.updateVerification') }}" method="post" enctype="multipart/form-data"
                                        class="space-y-6">
                                        @csrf

                                        <!-- Image upload area -->
                                        <div class="group relative">
                                            <div x-show="!imageUrl" class="space-y-4">
                                                <div
                                                    class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed   border-gray-300 font-roboto-slab bg-gray-50 p-8 text-center transition-colors group-hover:border-green-400">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <p class="mt-2 text-sm text-gray-600">
                                                        {{ __('profile.verification_image' )}}
                                                    </p>
                                                    <p class="mt-1 text-xs text-gray-500">
                                                        PNG, JPG, JPEG (max. 5MB)
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Image preview -->
                                            <div x-show="imageUrl" class="space-y-4">
                                                <div class="relative mx-auto max-w-xs">
                                                    <img :src="imageUrl" alt="Aperçu de l'image"
                                                        class="mx-auto h-40 w-40 rounded-xl border-2 border-gray-200 object-cover shadow-sm">
                                                    <button type="button" @click="imageUrl = ''"
                                                        class="absolute -right-2 -top-2 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Hidden file input -->
                                            <input id="file-upload" name="image_verification" type="file" accept="image/*"
                                                x-on:change="fileChosen($event)"
                                                class="absolute inset-0 h-full w-full cursor-pointer opacity-0">
                                        </div>

                                        <input type="hidden" name="profile_verifie" value="en cours">

                                        <!-- Submit button -->
                                        <div class="mt-6">
                                            <button type="submit"
                                                class="btn-gs-gradient w-full transform rounded-lg px-5 py-3 font-bold text-white shadow-md transition-all hover:scale-[1.02] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50"
                                                :disabled="!imageUrl">
                                                <i class="fas fa-paper-plane mr-2"></i>
                                                {{ __('profile.send') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Section mon compte --}}
                    <section x-show="pageSection=='compte'">

                        {{-- Storie --}}
                        <div class="flex items-center justify-between gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('profile.stories') }}</h2>
                            <div class="bg-green-gs h-0.5 flex-1"></div>
                            <button 
                            class="flex items-center gap-2 text-supaGirlRose hover:text-green-gs hover:bg-supaGirlRose px-5 py-2 bg-fieldBg rounded-md cursor-pointer">
                                {{ __('profile.add') }}
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                </svg>
                            </button>
                        </div>
                        {{-- 
                        <div class="flex flex-wrap items-center gap-10">
                            @livewire('create-story')
                            @livewire('stories-viewer', ['userViewStorie' => $user->id], key($user->id))
                            <div class="mt-4 w-full">
                                <h3 class="mb-2 text-lg font-semibold">Mes Stories</h3>
                                @livewire('storie-media-viewer', [], key('storie-media-viewer-'.now()->timestamp))
                            </div>
                        </div> --}}

                        {{-- StoriesTest --}}
                        @php $user = Auth()->user(); @endphp

                        <div class="flex flex-wrap items-center gap-10">
                        <button x-on:click="storyForm = true ; console.log('test', storyForm)" type="button"
                            class="flex h-24 w-24 items-center justify-center rounded-full border-2 border-white bg-red-500 shadow-md transition-colors hover:bg-gray-100"
                            data-tooltip-target="tooltip-add-story" data-tooltip-placement="top">
                            <div class="border-green-gs relative h-24 w-24 cursor-pointer rounded-full border-2">
                                <img @if ($avatar = $user->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                                    @else
                                    src="{{ asset('images/icon_logo.png') }}" @endif
                                    class="h-full w-full rounded-full object-cover" alt="{{ __('profile.add_story') }}">
                                <div
                                    class="text-green-gs absolute left-0 top-0 flex h-full w-full items-center justify-center rounded-full bg-gray-300/50 text-2xl font-bold">
                                    +</div>
                            </div>
                        </button>

                        @livewire('storie-media-viewer', [], key('storie-media-viewer-'.now()->timestamp))



                        </div>
                        <div x-cloak x-show="storyForm" x-transition.opacity.duration.300ms
                                x-trap.inert.noscroll="storyForm" x-on:keydown.esc.window="storyForm = false"
                                x-on:click.self="storyForm = false"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
                                role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">

                                <!-- Modal Dialog -->
                                <div x-show="storyForm" x-data="mediaViewer('')"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="relative w-full max-w-md rounded-xl bg-white shadow-xl">





                                <!-- Close Button -->
                                <button type="button" x-on:click="storyForm = false"
                                    class="absolute right-3 top-3 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <!-- Modal Content -->
                                <div class="p-6">
                                    <h3 id="story-modal-title" class="mb-6 text-center text-xl font-bold text-gray-900">
                                        Add a Story
                                    </h3>
                                    <form action="{{ route('stories.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                                        @csrf
                                        <!-- Media Preview -->
                                        <div class="flex justify-center">
                                            <div class="relative h-64 w-full overflow-hidden rounded-lg border-2 border-dashed border-gray-300 bg-gray-50">
                                                <template x-if="!mediaUrl">
                                                    <div class="flex h-full flex-col items-center justify-center p-4 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="mt-2 block text-sm text-gray-600">Media Preview</span>
                                                    </div>
                                                </template>
                                                <template x-if="mediaUrl">
                                                    <div x-show="isImage" class="h-full w-full">
                                                        <img :src="mediaUrl" class="h-full w-full object-cover" alt="Media Preview">
                                                    </div>
                                                    <div x-show="!isImage" class="h-full w-full">
                                                        <video :src="mediaUrl" class="h-full w-full object-cover" controls></video>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <!-- File Input -->
                                        <div class="mt-4">
                                            <label class="flex cursor-pointer items-center justify-between rounded-lg border-2 border-dashed border-gray-300 bg-white p-4 transition-colors hover:border-amber-500 hover:bg-amber-50">
                                                <div class="flex items-center">
                                                    <svg class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                    </svg>
                                                    <span class="ml-2 text-sm text-gray-700">
                                                        <span x-text="mediaUrl ? 'Change File' : 'Select File'"></span>
                                                        <span class="block text-xs text-gray-500">Image or Video</span>
                                                    </span>
                                                </div>
                                                <input name="media" type="file" accept="image/*,video/*" x-on:change="fileChosen($event)" class="hidden" required>
                                            </label>
                                        </div>
                                        <!-- Action Buttons -->
                                        <div class="mt-6 flex justify-end space-x-3">
                                            <button type="button" x-on:click="storyForm = false" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                Cancel
                                            </button>
                                            <button type="submit" class="inline-flex items-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                <svg x-show="!mediaUrl" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span x-text="mediaUrl ? 'Update' : 'Upload'"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                        {{-- Galerie --}}
                        <div class="flex w-full flex-wrap items-center gap-10">
                            {{-- <span class="w-full text-center text-green-gs font-bold font-roboto-slab">Aucun stories trovée !</span> --}}
                            @livewire('gallery-manager', ['user' => $user], key($user->id))
                        </div>

                        {{-- A propos de moi --}}
                        <div class="flex items-center justify-between gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('profile.about_me') }}</h2>
                            <div class="bg-green-gs h-0.5 flex-1"></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-10">
                            <div class="grid w-full grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                            

                                <x-profile-info-item 
                                    icon="age_icon.png"
                                    :alt="__('profile.age_icon')"
                                    :label="__('profile.age')"
                                    :value="Carbon::parse($user->date_naissance)->age"
                                    suffix="{{ __('profile.years_old') }}"
                                />



                           

                                <x-profile-info-item 
                                    icon="origine_icon.png"
                                    :alt="__('profile.origin_icon')"
                                    :label="__('profile.origin')"
                                    :value="$user->origine ?? __('profile.undefined')"
                                />
                               
                                <x-profile-info-item 
                                    icon="yeux_icon.png"
                                    :alt="__('profile.eye_color_icon')"
                                    :label="__('profile.eye_color')"
                                    :value="$user->couleurYeux ? $user->couleurYeux->getTranslation('name', app()->getLocale()) : __('profile.undefined')"
                                />
                                
                                <x-profile-info-item 
                                    icon="cheveux_icon.png"
                                    :alt="__('profile.hair_color_icon')"
                                    :label="__('profile.hair_color')"
                                    :value="$user->couleurCheveux ? $user->couleurCheveux->getTranslation('name', app()->getLocale()) : __('profile.undefined')"
                                />
                                
                                <x-profile-info-item 
                                    icon="tarif_icon.png"
                                    :alt="__('profile.rate_icon')"
                                    :label="__('profile.rate')"
                                    :value="$user->tarif ? $user->tarif : __('profile.contact_for_rates')"
                                    :suffix="'CHF'"
                                />
                                
                                <x-profile-info-item 
                                    icon="taille_icon.png"
                                    :alt="__('profile.height_icon')"
                                    :label="__('profile.height')"
                                    :value="$user->tailles ?? __('profile.undefined') . ' ' . __('profile.cm')"
                                />
                                
                
                                <x-profile-info-item 
                                    icon="poitrine_icon.png"
                                    :alt="__('profile.bust_icon')"
                                    :label="__('profile.bust')"
                                    :value="$user->poitrine ? $user->poitrine->getTranslation('name', app()->getLocale()) : __('profile.undefined')"
                                />
                                
                              

                                <x-profile-info-item 
                                    icon="mobilite.png"
                                    :alt="__('profile.mobility_icon')"
                                    :label="__('profile.mobility')"
                                    :value="$user->mobilite ? $user->mobilite->getTranslation('name', app()->getLocale()) : __('profile.undefined')"
                                />
                                
                          

                                <x-profile-info-item 
                                    icon="mensuration.png"
                                    :alt="__('profile.measurements_icon')"
                                    :label="__('profile.measurements')"
                                    :value="$user->mensuration ? $user->mensuration->getTranslation('name', app()->getLocale()) : __('profile.undefined')"
                                />
                                
                           
                                <x-profile-info-item 
                                    icon="taill_poit.png"
                                    :alt="__('profile.bust_size_icon')"
                                    :label="__('profile.bust_size')"
                                    :value="$user->taille_poitrine ?? __('profile.undefined')"
                                />
                                
                           
                                <x-info-display :items="$user->langues" type="language" />

                                <x-info-display :items="$user->paiement" type="payment"/>

                                
                            </div>
                        </div>


                        {{-- Description --}}
                        <div class="flex items-center justify-between gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('profile.description') }}
                            </h2>
                            <div class="bg-green-gs h-0.5 flex-1"></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-10">
                            <p class="font-roboto-slab text-textColor text-justify text-sm">{{ $user->apropos ?? '-' }}</p>
                        </div>

                        {{-- Service --}}
                        <div class="flex items-center justify-between gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
                                {{ __('profile.services_offered') }}</h2>
                            <div class="bg-green-gs h-0.5 flex-1"></div>
                        </div>
                        <div class="flex flex-col flex-wrap justify-center gap-5">
                            <div class="font-roboto-slab text-green-gs flex items-center gap-5 font-bold flex flex-wrap justify-between">
                               <span> {{ __('profile.categories') }}</span>
                                <button data-modal-target="editServiceModal" data-modal-toggle="editServiceModal"
                                    class=" cursor-pointer flex items-center gap-2 text-green-gs bg-fieldBg hover:text-fieldBg hover:bg-green-gs px-2 py-1 text-sm rounded-sm">
                                    {{ __('profile.edit') }}
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center gap-5">
                                @php
                                    $locale = session('locale', 'fr');

                                    $categories = $user->getCategoriesAttribute();
                                @endphp

                                @if (count($categories) > 0)
                                    @foreach ($categories as $category)
                                        <x-service-badge 
                                        :text="$category->getTranslation('nom', $locale, 'fr')"
                                        color="green-gs"
                                        hoverColor="fieldBg"
                                        borderColor="supaGirlRose"
                                        bgColor="fieldBg"
                                        textHoverColor="fieldBg"
                                    />
                                    @endforeach
                                @else
                                    <span class="text-textColorParagraph font-roboto-slab">{{ __('profile.no_categories') }}</span>
                                @endif
                            </div>

                            <div class="font-roboto-slab text-green-gs flex items-center gap-5 font-bold flex flex-wrap justify-between">
                              <span>  {{ __('profile.services_provided') }}</span>
                                <button data-modal-target="editServiceModal" data-modal-toggle="editServiceModal"
                                class=" cursor-pointer flex items-center gap-2 text-green-gs bg-fieldBg hover:text-fieldBg hover:bg-green-gs px-2 py-1 text-sm rounded-sm">
                                {{ __('profile.edit') }}
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                @php
                                    $locale = session('locale', 'fr');
                                    $services = $user->services ?? collect();
                                @endphp

                                @forelse($services as $service)
                                    <x-service-badge 
                                        :text="$service->getTranslation('nom', $locale, 'fr')"
                                        color="green-gs"
                                        hoverColor="fieldBg"
                                        borderColor="supaGirlRose"
                                        bgColor="fieldBg"
                                        textHoverColor="fieldBg"
                                    />
                                @empty
                                    <span class="text-textColorParagraph font-roboto-slab">{{ __('profile.no_services') }}</span>
                                @endforelse
                            </div>
                        </div>

                        {{-- Salon associé --}}
                        <div class="flex items-center justify-between gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
                                {{ __('profile.associated_salon') }}</h2>
                            <div class="bg-green-gs h-0.5 flex-1"></div>
                            <button data-modal-target="sendInvitationSalon" data-modal-toggle="sendInvitationSalon"
                            class="flex items-center gap-2 text-supaGirlRose hover:text-green-gs hover:bg-supaGirlRose px-5 py-2 bg-fieldBg rounded-md cursor-pointer">
                            {{ __('profile.invite_salon') }}
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex w-full flex-wrap items-center gap-10">
                            @if ($salonAssociers->isNotEmpty())
                                @foreach ($salonAssociers as $salonAssocier)
                                    @if ($salonAssocier->type === 'associe au salon')
                                        <livewire:salon-card name="{{ $salonAssocier->invited->nom_salon }}"
                                            canton="{{ $salonAssocier->invited->cantonget->nom ?? __('profile.unknown') }}"
                                            ville="{{ $salonAssocier->invited->villeget->nom ?? __('profile.unknown') }}"
                                            avatar='{{ $salonAssocier->invited->avatar }}'
                                            salonId='{{ $salonAssocier->invited->id }}'
                                            wire:key="{{ $salonAssocier->invited->id }}" />
                                    @else
                                        <livewire:salon-card name="{{ $salonAssocier->inviter->nom_salon }}"
                                            canton="{{ $salonAssocier->inviter->cantonget->nom ?? __('profile.unknown') }}"
                                            ville="{{ $salonAssocier->inviter->villeget->nom ?? __('profile.unknown') }}"
                                            avatar='{{ $salonAssocier->inviter->avatar }}'
                                            salonId='{{ $salonAssocier->inviter->id }}'
                                            wire:key="{{ $salonAssocier->inviter->id }}" />
                                    @endif
                                @endforeach
                            @else
                                <span
                                    class="text-green-gs font-roboto-slab w-full text-center font-bold">{{ __('profile.no_associated_salon') }}</span>
                            @endif
                        </div>
                        <!-- Modale pour l'invitation escort -->
                        <div x-data="" x-init="" id="sendInvitationSalon" tabindex="-1"
                            aria-hidden="true"
                            class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
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
                        <x-profile.description 
                            :title="__('profile.description')"
                            :content="$user->apropos"
                        />

                        {{-- A propos de moi --}}
                        <div class="flex items-center justify-between gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('profile.about_me') }}</h2>
                            <div class="bg-green-gs h-0.5 flex-1"></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-10">
                            <div class="grid w-full grid-cols-1 gap-5 xl:grid-cols-3">
                                <x-profile-info-item 
                                    icon="origine_icon.png"
                                    :alt="__('profile.age_icon')"
                                    :label="__('profile.category')"
                                    :value="$user->categorie['nom'][session('locale', 'fr')] ?? $user->categorie['nom']['fr'] ?? $user->categorie['nom'] ?? '-'"
                                    suffix=""
                                />
                              
                                <x-profile-info-item 
                                    icon="escort_icon.png"
                                    :alt="__('profile.number_of_girls')"
                                    :label="__('profile.number_of_girls')"
                                    :value="$user->nombreFille ? $user->nombreFille->getTranslation('name', app()->getLocale()) : __('profile.undefined')"
                                    suffix=""
                                />



                                <x-profile-info-item 
                                    icon="cart_icon.png"
                                    :alt="__('profile.other_contact')"
                                    :label="__('profile.other_contact')"
                                    :value="$user->autre_contact ?? '-'"
                                    suffix=""
                                />


                                <x-profile-info-item 
                                    icon="locationByDistance.png"
                                    :alt="__('profile.address')"
                                    :label="__('profile.address')"
                                    :value="$user->adresse ?? '-'"
                                    suffix=""
                                />



                                <x-profile-info-item 
                                    icon="tarif_icon.png"
                                    :alt="__('profile.rates_from')"
                                    :label="__('profile.rates_from')"
                                    :value="$user->tarif ?? __('profile.undefined')"
                                    suffix="CHF"
                                />
                                <x-info-display :items="$user->langues" type="language" />

                                <x-info-display :items="$user->paiement" type="payment"/>

                            </div>
                        </div>






                        {{-- Escort associé --}}
                        <div class="hidden flex-col items-center justify-between gap-5 py-5 xl:flex xl:flex-row">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
                                {{ __('profile.escort_of_salon') }}</h2>
                            <div class="bg-green-gs hidden h-0.5 flex-1 xl:block"></div>
                        </div>
                        @php
                                            $noSpecial = __('profile.no_specified');
                                        @endphp
                        <div class="mb-4 mt-10 flex w-full flex-wrap justify-around gap-4 px-4 xl:mt-0">
                            <!-- Colonne 1 -->
                            <div class="mb-4 w-full md:w-[48%]">
                                <h2 class="font-roboto-slab text-supaGirlRose mb-2 text-center text-md font-bold">
                                    {{ __('profile.created_escorts') }}</h2>

                                @if ($escorteCreateBySalons->isNotEmpty())
                                    <div id="default-carousel" class="relative w-full" data-carousel="static">
                                        <!-- Carousel wrapper -->
                                        <div class="relative min-h-[500px] overflow-hidden rounded-lg">
                                       
                                            @if ($escorteCreateBySalons->isNotEmpty())
                                                @foreach ($escorteCreateBySalons as $index => $acceptedInvitation)
                                                    <!-- Item {{ $index + 1 }} -->
                                                    <div class="hidden min-h-[405px] items-center duration-700 ease-in-out"
                                                        data-carousel-item>
                                                        <livewire:escort_card name="{{ $acceptedInvitation->invited->prenom ?? $acceptedInvitation->invited->pseudo }}"
                                                            canton="{{ $acceptedInvitation->invited->cantonget->nom ?? $noSpecial }}"
                                                            ville="{{ $acceptedInvitation->invited->villeget->nom ?? $noSpecial }}"
                                                            avatar="{{ $acceptedInvitation->invited->avatar }}"
                                                            escortId="{{ $acceptedInvitation->invited->id }}"
                                                            wire:key="{{ $acceptedInvitation->invited->id }}" />
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="flex h-full items-center justify-center">
                                                    <span
                                                        class="text-green-gs font-roboto-slab text-center text-sm font-bold ">{{ __('profile.no_created_escorts') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Slider indicators -->
                                        <div class="z-30 my-3 flex justify-center space-x-3 rtl:space-x-reverse">
                                            @foreach ($escorteCreateBySalons as $index => $acceptedInvitation)
                                                <button type="button"
                                                    class="{{ $index === 0 ? 'bg-blue-500' : 'bg-gray-300' }} h-3 w-3 rounded-full"
                                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                                    aria-label="Slide {{ $index + 1 }}"
                                                    data-carousel-slide-to="{{ $index }}"></button>
                                            @endforeach
                                        </div>
                                        <!-- Slider controls -->
                                        <!-- Bouton PREV -->
                                        <button type="button"
                                            class="group absolute start-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                                            data-carousel-prev>
                                            <span
                                                class="bg-green-gs group-hover:bg-green-gs/80 group-focus:ring-green-gs/50 inline-flex h-10 w-10 items-center justify-center rounded-full group-focus:outline-none group-focus:ring-4">
                                                <svg class="h-4 w-4 text-white rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                                </svg>
                                                <span class="sr-only">Previous</span>
                                            </span>
                                        </button>

                                        <!-- Bouton NEXT -->
                                        <button type="button"
                                            class="group absolute end-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                                            data-carousel-next>
                                            <span
                                                class="bg-green-gs group-hover:bg-green-gs/80 group-focus:ring-green-gs/50 inline-flex h-10 w-10 items-center justify-center rounded-full group-focus:outline-none group-focus:ring-4">
                                                <svg class="h-4 w-4 text-white rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                                </svg>
                                                <span class="sr-only">Next</span>
                                            </span>
                                        </button>
                                    </div>
                                @else
                                    <x-empty-state message="{{ __('profile.no_created_escorts') }}" />
                                @endif
                            </div>

                            <!-- Colonne 2 -->
                            <div class="w-full md:w-[48%]">
                                <h2 class="font-roboto-slab text-supaGirlRose mb-2 text-center text-md font-bold">
                                    {{ __('profile.invited_escorts') }}</h2>

                                @if ($acceptedInvitations->isNotEmpty())
                                    <div id="associated-escorts-carousel" class="relative w-full" data-carousel="static">
                                        <!-- Carousel wrapper -->
                                        <div class="relative min-h-[500px] overflow-hidden rounded-lg">
                                            @if ($acceptedInvitations->isNotEmpty())
                                                @foreach ($acceptedInvitations as $index => $acceptedInvitation)
                                                    <!-- Item {{ $index + 1 }} -->
                                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                        @if ($acceptedInvitation->type === 'associe au salon')
                                                            <livewire:escort_card
                                                                name="{{ $acceptedInvitation->inviter->prenom ?? $acceptedInvitation->inviter->nom_salon }}"
                                                                canton="{{ $acceptedInvitation->inviter->cantonget->nom ?? $noSpecial }}"
                                                                ville="{{ $acceptedInvitation->inviter->villeget->nom ?? $noSpecial }}"
                                                                avatar="{{ $acceptedInvitation->inviter->avatar }}"
                                                                escortId="{{ $acceptedInvitation->inviter->id }}"
                                                                wire:key="{{ $acceptedInvitation->inviter->id }}" />
                                                        @else
                                                            <livewire:escort_card
                                                                name="{{ $acceptedInvitation->invited->prenom ?? $acceptedInvitation->invited->nom_salon }}"
                                                                canton="{{ $acceptedInvitation->invited->cantonget->nom ?? $noSpecial }}"
                                                                ville="{{ $acceptedInvitation->invited->villeget->nom ?? $noSpecial }}"
                                                                avatar="{{ $acceptedInvitation->invited->avatar }}"
                                                                escortId="{{ $acceptedInvitation->invited->id }}"
                                                                wire:key="{{ $acceptedInvitation->invited->id }}" />
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="flex h-full items-center justify-center">
                                                    <span
                                                        class="text-green-gs font-roboto-slab text-center text-sm font-bold ">{{ __('profile.no_associated_escorts') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- Slider indicators -->
                                        <div class="z-30 my-3 flex justify-center space-x-3 rtl:space-x-reverse">
                                            @if ($acceptedInvitations->isNotEmpty())
                                                @foreach ($acceptedInvitations as $index => $acceptedInvitation)
                                                    <button type="button"
                                                        class="{{ $index === 0 ? 'bg-green-gs' : 'bg-gray-400' }} h-3 w-3 rounded-full"
                                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                                        aria-label="Slide {{ $index + 1 }}"
                                                        data-carousel-slide-to="{{ $index }}"></button>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!-- Slider controls -->
                                        <!-- Bouton PREV -->
                                        <button type="button"
                                            class="group absolute start-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                                            data-carousel-prev>
                                            <span
                                                class="bg-green-gs group-hover:bg-green-gs/80 group-focus:ring-green-gs/50 inline-flex h-10 w-10 items-center justify-center rounded-full group-focus:outline-none group-focus:ring-4">
                                                <svg class="h-4 w-4 text-white rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                                </svg>
                                                <span class="sr-only">Previous</span>
                                            </span>
                                        </button>

                                        <!-- Bouton NEXT -->
                                        <button type="button"
                                            class="group absolute end-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                                            data-carousel-next>
                                            <span
                                                class="bg-green-gs group-hover:bg-green-gs/80 group-focus:ring-green-gs/50 inline-flex h-10 w-10 items-center justify-center rounded-full group-focus:outline-none group-focus:ring-4">
                                                <svg class="h-4 w-4 text-white rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                                </svg>
                                                <span class="sr-only">Next</span>
                                            </span>
                                        </button>
                                    </div>
                                @else
                                    <x-empty-state message="{{ __('profile.no_associated_escorts') }}" />
                                @endif
                            </div>

                            <x-profile.action-buttons 
                                :createButtonText="__('profile.create_escort')"
                                :inviteButtonText="__('profile.invite_escort')"
                            />
                        </div>


                        {{-- Modale pour invitation escort --}}
                        <div x-data="" x-init="" id="sendInvitationEscort"
                            tabindex="-1" aria-hidden="true"
                            class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
                            <!-- Modale -->
                            <x-invitation-tabs :escortsNoInvited="$escortsNoInvited" :listInvitation="$listInvitation" />
                        </div>
                        {{-- Modale pour créer un escort --}}
                        <div x-data="" x-init="" id="createEscorte" tabindex="-1"
                            aria-hidden="true"
                            class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
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
                    <div class="flex items-center justify-between py-5">
                        <h2 class="font-roboto-slab text-green-gs my-5 mr-4 text-2xl font-bold">{{ __('profile.discussions') }}</h2>
                        <div class="bg-green-gs mx-auto h-1 w-[90%]"></div>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
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
                steps: "{{ $user->profile_type }}" == 'invite' ? [
                    '{{ __('profile.personal_information') }}',
                    '{{ __('profile.additional_information') }}'
                ] : [
                    '{{ __('profile.personal_information') }}',
                    '{{ __('profile.professional_information') }}',
                    '{{ __('profile.additional_information') }}'
                ],
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

        function mediaViewer(src = '') {
            return {
                mediaUrl: src,
                isImage: true,
                fileChosen(event) {
                    this.fileToDataUrl(event, (result) => {
                        this.mediaUrl = result;
                        this.isImage = event.target.files[0].type.startsWith('image/');
                    });
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
                sendingMessage: false,
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
                searchResults: [],
                currentPage: 1,
                itemsPerPage: 10,
                modalIsOpen: false,

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
                        this.searchResults = response.data.records;
                        // document.getElementById('search-list').innerHTML = response.data.records;
                    } catch (error) {
                        console.error(error);
                    }
                },

                async loadContacts(page = 1) {
                    this.loadingContacts = true;
                    try {
                        const response = await axios.get('/messenger/fetch-contacts');
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
                        if (userResponse.data?.shared_links) {
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

                    // Activer l'état de chargement
                    this.sendingMessage = true;

                    const formData = new FormData();
                    formData.append('id', this.currentChat);
                    formData.append('message', this.newMessage);
                    formData.append('temporaryMsgId', Date.now());

                    if (this.fileToUpload) {
                        formData.append('attachment', this.fileToUpload);
                    }

                    try {
                        const response = await axios.post('/messenger/send-message', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });

                        if (response.data.success) {
                            const no_messages = document.querySelector(`#no-messages`);
                            if (no_messages) {
                                no_messages.remove();
                            }
                        }

                        // Ajouter le nouveau message
                        let messagesList = document.getElementById('messages-list');
                        messagesList.insertAdjacentHTML('beforeend', response.data.message);

                        // Réinitialiser
                        this.newMessage = '';
                        this.clearAttachment();
                        this.loadContacts();

                        // Scroll vers le bas
                        this.scrollToBottom();
                    } catch (error) {
                        console.error(error);
                        showToast('Erreur lors de l\'envoi du message', 'error');
                    } finally {
                        // Désactiver l'état de chargement dans tous les cas
                        this.sendingMessage = false;
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
                            const messageElement = document.querySelector(`[data-id="${messageId}"]`);
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

        // Visibility
        function visibility() {
            return {
                customVisibility: {{ auth()->user()->visibility === 'custom' ? 'true' : 'false' }},
            };
        }

        // Country Selector
        function countrySelector(allCountries, initialSelected = []) {
            return {
                countries: allCountries,
                selected: [...initialSelected],
                search: '',
                open: false,
                highlightedIndex: 0,
                get filtered() {
                    let results = {};
                    const term = this.search.toLowerCase();
                    for (const [code, name] of Object.entries(this.countries)) {
                        if (
                            name.toLowerCase().includes(term) &&
                            !this.selected.includes(code)
                        ) {
                            results[code] = name;
                        }
                    }
                    return results;
                },
                select(code) {
                    if (!this.selected.includes(code)) {
                        this.selected.push(code);
                    }
                    this.search = '';
                    this.open = false;
                    this.highlightedIndex = 0;
                },
                remove(code) {
                    this.selected = this.selected.filter(c => c !== code);
                },
                navigate(direction) {
                    const keys = Object.keys(this.filtered);
                    if (direction === 'next') {
                        this.highlightedIndex = (this.highlightedIndex + 1) % keys.length;
                    } else if (direction === 'prev') {
                        this.highlightedIndex = (this.highlightedIndex - 1 + keys.length) % keys.length;
                    }
                }
            };
        }
    </script>
@endsection
