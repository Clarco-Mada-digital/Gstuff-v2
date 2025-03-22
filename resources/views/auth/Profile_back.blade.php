@extends('layouts.base')
@php
    use Carbon\Carbon;
@endphp

@section('pageTitle')
    Profile page
@endsection

@section('content')
<div class="relative w-full min-h-[30vh]" style="background: url('{{ asset('images/Logo_lg.svg') }}') center center /cover">
    {{-- ... (cover image button - no changes needed) ... --}}
</div>

<div x-data="{pageSection: $persist('compte'), userType:'{{ $user->profile_type }}', completionPercentage: 0, fetchCompletionPercentage() { fetch('/profile-completion-percentage') .then(response => response.json()) .then(data => { this.completionPercentage = data.percentage; }); }}" x-init="fetchCompletionPercentage()" class="container flex flex-col xl:flex-row justify-center mx-auto">

    {{-- Left section profile --}}
    <div class="min-w-1/4 flex flex-col items-center gap-3">
        {{-- ... (profile image and links - no changes needed) ... --}}
        <p class="font-bold">{{ $user->user_name ?? $user->name ?? $user->nom_salon }}</p>
        <div class="flex items-center justify-center gap-2 text-green-gs">
            <a href="#" class="flex items-center gap-1">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none">
                    <path d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                {{ $user->canton ?? 'Non renseigné' }}
            </a>
            <a href="tel:{{ $user->telephone }}" class="flex items-center gap-1">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21z"></path>
                </svg>
                {{ $user->telephone ?? 'Non renseigné' }}
            </a>
        </div>
        {{-- ... (rest of left section - no changes needed unless you want to make menu dynamic) ... --}}
    </div>

    {{-- Modale pour l'amelioration du profile --}}
    <div x-data="multiStepForm()" x-init="fetchDropdownData(); getInitialCompletionPercentage()" id="addInfoProf" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <!-- Modale -->
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90vw] max-h-[90vh] xl:max-w-7xl overflow-y-auto">
            {{-- ... (steps indicator - no changes needed) ... --}}

            <div class="w-full mb-4 bg-gray-200 rounded-full dark:bg-gray-700">
                <div class="bg-green-500 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" :style="`width: ${completionPercentage}%`" x-text="`${completionPercentage}% Complete`"> 0% </div>
            </div>

            <!-- Contenu du formulaire -->
            <form @submit.prevent="submitForm" action="{{ route('profile.update') }}" method="POST">
                @csrf
                <!-- Étape 1: Informations personnelles -->
                <div x-show="currentStep === 0">
                    <h2 class="text-lg font-semibold mb-4">Informations personnelles</h2>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">intitule</label>
                        <select name="intitule" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option hidden> -- </option>
                            <option value="monsieur" @if($user->intitule == 'monsieur') selected @endif>monsieur</option>
                            <option value="madame" @if($user->intitule == 'madame') selected @endif>madame</option>
                            <option value="mademoiselle" @if($user->intitule == 'mademoiselle') selected @endif>mademoiselle</option>
                            <option value="autre" @if($user->intitule == 'autre') selected @endif>autre</option>
                        </select>
                    </div>
                    @if (Auth::user()->profile_type=='salon')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nom du proprietaire</label>
                        <input type="text" name="nom_proprietaire" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->nom_proprietaire }}">
                    </div>
                    @endif
                    @if (Auth::user()->profile_type=='escorte')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">name</label>
                        <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->name }}">
                    </div>
                    @endif
                    @if (Auth::user()->profile_type=='invite')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">user_name</label>
                        <input type="text" name="user_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->user_name }}">
                    </div>
                    @endif
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->email }}">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Numéro téléphone</label>
                        <input type="tel" name="telephone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->telephone }}">
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
                        <select name="canton" id="canton" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option hidden> -- </option>
                            @foreach ($cantons as $canton)
                                <option value="{{ $canton->title }}" @if($user->canton == $canton->title) selected @endif>{{ $canton->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ville</label>
                        <select name="ville" id="ville" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option hidden> -- </option>
                            @foreach ($villes as $ville)
                                <option value="{{ $ville->title }}" @if($user->ville == $ville->title) selected @endif>{{ $ville->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Étape 2: Informations professionnelles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5" :class="userType == 'invite' ? 'hidden':''" x-show="currentStep === 1">
                    <h2 class="text-lg font-semibold mb-4 col-span-2">Informations professionnelles</h2>
                    <div class="mb-4 col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Catégories</label>
                        <select name="categorie" id="categorie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option hidden> -- </option>
                            @foreach ($categories as $categorie)
                                <option value="{{ $categorie }}" @if($user->categorie == $categorie) selected @endif>{{ $categorie }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- ... (rest of professional info - adapt dropdowns similarly using @foreach and data from controller) ... --}}
                    @if (Auth::user()->profile_type=='escorte')
                    <div class="mb-4 col-span-2 md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Pratiques sexuelles</label>
                        <select name="pratique_sexuelles" id="pratique_sexuelles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option hidden> -- </option>
                            @foreach ($pratiquesSexuelles as $pratique)
                                <option :value="{{ $pratique }}" x-text="{{ $pratique }}" @if($user->pratique_sexuelles == $pratique) selected @endif></option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    {{-- ... (Continue adapting other dropdowns in step 2 and step 3) ... --}}
                </div>

                <!-- Étape 3: Informations complémentaires -->
                <div @if (Auth::user()->profile_type == 'invite') x-show="currentStep === 1" @else x-show="currentStep === 2" @endif >
                    {{-- ... (rest of step 3 - no major changes needed unless you have dynamic data here) ... --}}
                </div>

                {{-- ... (navigation buttons - no changes needed) ... --}}
            </form>
        </div>
    </div>

    {{-- Right section profile --}}
    <div class="min-w-3/4 px-5 py-5">
        {{-- ... (profile completion alert - completionPercentage is already dynamic) ... --}}

        {{-- ... (rest of right section - adapt sections to display dynamic data as needed) ... --}}
        <div x-show="userType=='invite'">
            {{-- Section mon compte --}}
            <section x-show="pageSection=='compte'">
                {{-- Information --}}
                <div class="flex items-center justify-between py-5">
                    <h2 class="font-dm-serif font-bold text-2xl">Mes informations</h2>
                    {{-- ... (modifier button - no changes needed) ... --}}
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 items-center gap-10">
                    <span class="flex items-center gap-2"><svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M5.85 17.1q1.275-.975 2.85-1.537T12 15t3.3.563t2.85 1.537q.875-1.025 1.363-2.325T20 12q0-3.325-2.337-5.663T12 4T6.337 6.338T4 12q0 1.475.488 2.775T5.85 17.1M12 13q-1.475 0-2.488-1.012T8.5 9.5t1.013-2.488T12 6t2.488 1.013T15.5 9.5t-1.012 2.488T12 13m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22"/></svg> {{ $user->user_name }}</span>
                    <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M14.5 8a6.5 6.5 0 1 1-13 0a6.5 6.5 0 0 1 13 0M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-9.75 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-1V7H7a.75.75 0 0 0 0 1.5h.25v2zM8 6a1 1 0 1 0 0-2a1 1 0 0 0 0 2" clip-rule="evenodd"/></svg> {{ Carbon::parse($user->date_naissance)->age }} ans</span>
                    {{-- ... (rest of user info - adapt if needed) ... --}}
                    <span class="flex items-center gap-2"> <svg class="w-5 h-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M4.35 20.7q-.5.2-.925-.112T3 19.75v-14q0-.325.188-.575T3.7 4.8L9 3l6 2.1l4.65-1.8q.5-.2.925.113T21 4.25v8.425q-.875-1.275-2.187-1.975T16 10q-.5 0-1 .088t-1 .262v-3.5l-4-1.4v13.075zM20.6 22l-2.55-2.55q-.45.275-.962.413T16 20q-1.65 0-2.825-1.175T12 16t1.175-2.825T16 12t2.825 1.175T20 16q0 .575-.137 1.088t-.413.962L22 20.6zM16 18q.85 0 1.413-.5T18 16q.025-.85-.562-1.425T16 14t-1.425.575T14 16t.575 1.425T16 18"/></svg> {{ $user->canton }} - {{ $user->ville }}</span>
                </div>
                {{-- ... (rest of "Mon compte" section - adapt as needed) ... --}}
            </section>
            {{-- ... (rest of sections for invite, escort, salon - adapt similarly) ... --}}
        </div>

        {{-- ... (sections for escort and salon - adapt similarly) ... --}}

    </div>

</div>
@stop

@section('extraScripts')
<script>
    function multiStepForm() {
        return {
            steps: "{{ $user->profile_type }}"=='invite' ? ['Informations personnelles', 'Informations complémentaires'] : ['Informations personnelles', 'Informations professionnelles', 'Informations complémentaires'],
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
            saveAndQuit(){
                document.getElementById('addInfoSubmit').click();
            },
            submitForm() {
                alert('Formulaire soumis avec succès !');
            }
        };
    }
</script>
@endsection
