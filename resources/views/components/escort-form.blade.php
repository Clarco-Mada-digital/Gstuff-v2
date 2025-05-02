@props(['user'])


<div class="bg-white rounded-lg shadow-lg p-6  w-full h-[80vh] md:w-[70vw] xl:w-[35vw] mx-auto overflow-y-auto">
    <div class="w-full py-3 px-2 flex flex-col items-center justify-center gap-15">
        <h2 class="font-dm-serif text-2xl font-bold text-center">Créer un nouvel escorte</h2>


        {{-- Inscription Escort Formulaire --}}
        {{-- <form class="w-full mx-auto flex flex-col gap-5" action="{{ route('createEscorteBySalon') }}" method="POST">
            @csrf
            <input type="hidden" name="id_salon" value="{{ $user }}">

            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="prenom" id="floating_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('prenom') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('prenom') }}" autocomplete="prenom" required />
                <label for="floating_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('prenom') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Prenom *</label>
                @error('prenom')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_genre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('name') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Genre *</label>
                <select name="genre" id="floating_genre" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('genre') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('genre') }}" autocomplete="genre" required>
                    <option>---</option>
                    <option value="femme">Femme</option>
                    <option value="homme">Homme</option>
                    <option value="trans">Trans</option>
                    <option value="gay">Gay</option>
                    <option value="lesbienne">Lesbienne</option>
                    <option value="bisexuelle">Bisexuelle</option>
                    <option value="queer">Queer</option>
                </select>
                @error('genre')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('email') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Email address *</label>
                @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="date" name="date_naissance" id="floating_date_naissance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
                <label for="floating_date_naissance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('date_naissance') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Date anniversaire *</label>
                @error('date_naissance')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{__('Créer')}}</button>
        </form> --}}

        <form class="w-full mx-auto flex flex-col gap-5" action="{{ route('createEscorteBySalon') }}" method="POST">
            @csrf
            <input type="hidden" name="id_salon" value="{{ $user }}">
        
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="prenom" id="floating_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('prenom') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('prenom') }}" autocomplete="prenom" required />
                <label for="floating_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('prenom') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Prenom *</label>
                @error('prenom')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
        
            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_genre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('genre') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Genre *</label>
                <select name="genre" id="floating_genre" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('genre') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('genre') }}" autocomplete="genre" required>
                    <option value="">---</option>
                    <option value="femme">Femme</option>
                    <option value="homme">Homme</option>
                    <option value="trans">Trans</option>
                    <option value="gay">Gay</option>
                    <option value="lesbienne">Lesbienne</option>
                    <option value="bisexuelle">Bisexuelle</option>
                    <option value="queer">Queer</option>
                </select>
                @error('genre')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
        
            <div class="relative z-0 w-full mb-5 group">
                <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('email') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Email address *</label>
                @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
        
            <div class="relative z-0 w-full mb-5 group">
                <input type="date" name="date_naissance" id="floating_date_naissance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
                <label for="floating_date_naissance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('date_naissance') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Date anniversaire *</label>
                @error('date_naissance')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
        
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{__('Créer')}}</button>
        </form>
        

    </div>
</div>



{{-- 
@props([
    'user',
    'cantons',
    'villes',
    'genres',
    'escortCategories',
    'services',
    'langues',
    'paiements',
    'tarifs',
    'pratiquesSexuelles',
    'oriantationSexuelles',
    'origines',
    'couleursYeux',
    'couleursCheveux',
    'mensurations',
    'poitrines',
    'taillesPoitrine',
    'pubis',
    'tatouages',
    'mobilites'
])

<div class="bg-white rounded-lg shadow-lg p-6 w-full h-[80vh] md:w-[70vw] xl:w-[35vw] mx-auto overflow-y-auto">
    <div class="w-full py-3 px-2 flex flex-col items-center justify-center gap-15">
        <h2 class="font-dm-serif text-2xl font-bold text-center">Créer un nouvel escort</h2>

        <form class="w-full mx-auto flex flex-col gap-5" action="{{ route('createEscorteBySalon') }}" method="POST">
            @csrf
            <input type="hidden" name="id_salon" value="{{ $user }}">

            <!-- Prénom -->
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="prenom" id="floating_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('prenom') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('prenom') }}" autocomplete="prenom" required />
                <label for="floating_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('prenom') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Prénom *</label>
                @error('prenom')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Genre -->
            <div class="relative z-0 w-full mb-5 group">
                <label for="floating_genre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('genre') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Genre *</label>
                <select name="genre" id="floating_genre" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('genre') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('genre') }}" autocomplete="genre" required>
                    <option value="">---</option>
                    @foreach ($genres as $genre)
                    {{ $genres }}
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
                @error('genre')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="relative z-0 w-full mb-5 group">
                <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('email') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Email address *</label>
                @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Date de naissance -->
            <div class="relative z-0 w-full mb-5 group">
                <input type="date" name="date_naissance" id="floating_date_naissance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
                <label for="floating_date_naissance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('date_naissance') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Date anniversaire *</label>
                @error('date_naissance')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Informations personnelles -->
            <div x-data="{ cantons: @js($cantons), selectedCanton: {{ $user->canton?->id ?? 1 }}, villes: @js($villes), availableVilles: @js($villes) }" x-show="currentStep === 0">
                <h2 class="text-lg font-semibold mb-4">Informations personnelles</h2>

                <!-- Intitulé -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Intitulé</label>
                    <div class="flex">
                        <div id="states-button" data-dropdown-toggle="dropdown-states" class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-50 border border-e-0 border-gray-300 rounded-s-lg focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600" type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                <path fill="currentColor" d="M208 20h-40a12 12 0 0 0 0 24h11l-15.64 15.67A68 68 0 1 0 108 178.92V192H88a12 12 0 0 0 0 24h20v16a12 12 0 0 0 24 0v-16h20a12 12 0 0 0 0-24h-20v-13.08a67.93 67.93 0 0 0 46.9-100.84L196 61v11a12 12 0 0 0 24 0V32a12 12 0 0 0-12-12m-88 136a44 44 0 1 1 44-44a44.05 44.05 0 0 1-44 44" />
                            </svg>
                        </div>
                        <select name="genre" id="intitule" class="bg-gray-50 border border-s-0 border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 block w-full p-2.5 ps-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            <option hidden value=""> -- </option>
                            @foreach ($genres as $genre)
                            {{ $genres }}
                            <option value="{{ $genre->id }}" @if ($user->genre == $genre->id) selected @endif>{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Prénom -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Prénom</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M5.85 17.1q1.275-.975 2.85-1.537T12 15t3.3.563t2.85 1.537q.875-1.025 1.363-2.325T20 12q0-3.325-2.337-5.663T12 4T6.337 6.338T4 12q0 1.475.488 2.775T5.85 17.1M12 13q-1.475 0-2.488-1.012T8.5 9.5t1.013-2.488T12 6t2.488 1.013T15.5 9.5t-1.012 2.488T12 13m0 9q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
                            </svg>
                        </div>
                        <input type="text" id="name" name="prenom" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->prenom }}" />
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12v1.45q0 1.475-1.012 2.513T18.5 17q-.875 0-1.65-.375t-1.3-1.075q-.725.725-1.638 1.088T12 17q-2.075 0-3.537-1.463T7 12t1.463-3.537T12 7t3.538 1.463T17 12v1.45q0 .65.425 1.1T18.5 15t1.075-.45t.425-1.1V12q0-3.35-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20h4q.425 0 .713.288T17 21t-.288.713T16 22zm0-7q1.25 0 2.125-.875T15 12t-.875-2.125T12 9t-2.125.875T9 12t.875 2.125T12 15" />
                            </svg>
                        </div>
                        <input type="email" id="email-input" name="email" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->email }}" />
                    </div>
                </div>

                <!-- Numéro de téléphone -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                                <path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                            </svg>
                        </div>
                        <input type="text" id="phone-input" name="telephone" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $user->telephone }}" />
                    </div>
                </div>

                <!-- Adresse -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input type="text" name="adresse" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->adresse }}">
                </div>

                <!-- NPA -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">NPA</label>
                    <input type="text" name="npa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ $user->npa }}">
                </div>

                <!-- Canton -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Canton</label>
                    <select x-model="selectedCanton" x-on:change="villes = availableVilles.filter(ville => ville.canton_id == selectedCanton)" name="canton" id="canton" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        <template x-for="canton in cantons" :key="canton.id">
                            <option :value="canton.id" :selected="'{{ $user->canton['id'] ?? '' }}' == canton.id ? true : false" x-text="canton.nom"></option>
                        </template>
                    </select>
                </div>

                <!-- Ville -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Ville</label>
                    <select name="ville" id="ville" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="localStorage.setItem('villeNom', this.options[this.selectedIndex].text);">
                        <option hidden value=""> -- </option>
                        <template x-for="ville in villes" :key="ville.id">
                            <option :value="ville.id" :selected="'{{ $user->ville }}' == ville.id ? true : false" x-text="ville.nom"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Informations professionnelles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5" :class="userType == 'invite' ? 'hidden' : ''" x-show="currentStep === 1">
                <h2 class="text-lg font-semibold mb-4 col-span-2">Informations professionnelles</h2>

                <!-- Catégorie -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Catégories</label>
                    <select name="categorie" id="escort_categorie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($escortCategories as $categorie)
                        <option value="{{ $categorie->id }}" @if ($user->categorie ? $user->categorie->id == $categorie->id : false) selected @endif>{{ $categorie->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pratiques sexuelles -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Pratiques sexuelles</label>
                    <select name="pratique_sexuelles" id="pratique_sexuelles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($pratiquesSexuelles as $pratique)
                        <option value="{{ $pratique }}" @if ($user->pratique_sexuelles == $pratique) selected @endif>{{ $pratique }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Orientation sexuelle -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Orientation sexuelle</label>
                    <select name="oriantation_sexuelles" id="oriantation_sexuelles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($oriantationSexuelles as $oriantation)
                        <option value="{{ $oriantation }}" @if ($user->oriantation_sexuelles == $oriantation) selected @endif>{{ $oriantation }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Services -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Services</label>
                    <x-select_object_multiple name="service" :options="$services" :value="$user->service" label="Mes services" />
                </div>

                <!-- Taille -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Taille en cm</label>
                    <input class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" type="number" name="tailles" id="taille" placeholder="Taille en cm" value="{{ $user->tailles }}">
                </div>

                <!-- Origine -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Origine</label>
                    <select name="origine" id="origine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($origines as $origine)
                        <option value="{{ $origine }}" @if ($user->origine == $origine) selected @endif>{{ $origine }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Couleur des yeux -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Couleur des yeux</label>
                    <select name="couleur_yeux" id="couleur_yeux" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($couleursYeux as $yeux)
                        <option value="{{ $yeux }}" @if ($user->couleur_yeux == $yeux) selected @endif>{{ $yeux }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Couleur des cheveux -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Couleur des cheveux</label>
                    <select name="couleur_cheveux" id="couleur_cheveux" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($couleursCheveux as $cheveux)
                        <option value="{{ $cheveux }}" @if ($user->couleur_cheveux == $cheveux) selected @endif>{{ $cheveux }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Mensuration -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Mensuration</label>
                    <select name="mensuration" id="mensuration" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($mensurations as $mensuration)
                        <option value="{{ $mensuration }}" @if ($user->mensuration == $mensuration) selected @endif>{{ $mensuration }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Poitrine -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Poitrine</label>
                    <select name="poitrine" id="poitrine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($poitrines as $poitrine)
                        <option value="{{ $poitrine }}" @if ($user->poitrine == $poitrine) selected @endif>{{ $poitrine }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Taille de poitrine -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Taille de poitrine</label>
                    <select id="taille_poitrine" name="taille_poitrine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($taillesPoitrine as $taillePoitrine)
                        <option value="{{ $taillePoitrine }}" @if ($user->taille_poitrine == $taillePoitrine) selected @endif>{{ $taillePoitrine }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Poils du pubis -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Poils du pubis</label>
                    <select id="pubis" name="pubis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($pubis as $pubi)
                        <option value="{{ $pubi }}" @if ($user->pubis == $pubi) selected @endif>{{ $pubi }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tatouages -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Tatouages</label>
                    <select id="tatouages" name="tatouages" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($tatouages as $tatou)
                        <option value="{{ $tatou }}" @if ($user->tatouages == $tatou) selected @endif>{{ $tatou }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Mobilité -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Mobilité</label>
                    <select id="mobilete" name="mobilite" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden value=""> -- </option>
                        @foreach ($mobilites as $mobilite)
                        <option value="{{ $mobilite }}" @if ($user->mobilite == $mobilite) selected @endif>{{ $mobilite }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Langues -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Langues</label>
                    <x-select_multiple name="langues" :options="$langues" :value="explode(',', $user->langues)" label="Langues parlées" />
                </div>

                <!-- Tarif -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Tarif</label>
                    <select id="tarif" name="tarif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option hidden> -- </option>
                        @foreach ($tarifs as $tarif)
                        <option value="{{ $tarif }}" @if ($user->tarif == $tarif) selected @endif>À partir de {{ $tarif }}.-CHF</option>
                        @endforeach
                    </select>
                </div>

                <!-- Moyens de paiement -->
                <div class="mb-4 col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Moyens de paiement</label>
                    <x-select_multiple name="paiement" :options="$paiements" :value="explode(',', $user->paiement)" label="Moyens de paiement" />
                </div>

                <!-- À propos -->
                <div class="mb-4 col-span-2">
                    <label class="block text-sm font-medium text-gray-700">À propos</label>
                    <textarea rows="4" name="apropos" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">{{ $user->apropos ?? '' }}</textarea>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{ __('Créer') }}</button>
        </form>
    </div>
</div> --}}
