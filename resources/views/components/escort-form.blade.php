@props(['user'])


<div class="bg-white rounded-lg shadow-lg p-6  w-full h-[80vh] md:w-[70vw] xl:w-[35vw] mx-auto overflow-y-auto">
    <div class="w-full py-3 px-2 flex flex-col items-center justify-center gap-15">
        <h2 class="font-dm-serif text-2xl font-bold text-center">Créer un nouvel escorte</h2>


        {{-- Inscription Escort Formulaire --}}
        <form class="w-full mx-auto flex flex-col gap-5" action="{{ route('createEscorteBySalon') }}" method="POST">
            @csrf
            <input type="hidden" name="profile_type" value="escorte">
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
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="password" id="floating_pass" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
                <label for="floating_pass" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">{{__('Mot de passe')}} *</label>
                @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="password_confirmation" id="floating_pass_conf" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
                <label for="floating_pass_conf" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">{{__('Confirmer votre mot de passe')}} *</label>
                @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                @enderror
            </div>
            <input id="cgu_accepted" type="checkbox" checked name="cgu_accepted" class="hidden w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-green-gs dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-gs dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" autocomplete="cgu_accepted" {{ old('cgu_accepted') ? 'checked' : '' }} required />

            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{__('Créer')}}</button>
        </form>

    </div>
</div>