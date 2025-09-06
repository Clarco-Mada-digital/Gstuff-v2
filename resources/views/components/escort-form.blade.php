@props(['user'])

<div
    class="font-roboto-slab text-green-gs mx-12 h-[90vh] w-full overflow-y-auto rounded-lg bg-white p-6 shadow-lg md:w-[85vw] xl:w-[80vw]">
    <div class="flex w-full flex-col items-center justify-center px-2 py-3">
        <div class="mb-3">
            <h2 class="font-roboto-slab text-green-gs text-center text-2xl font-bold">
                {{ __('profile.create_new_escort') }}</h2>
        </div>

        <form id="createEscorteForm" class="mx-auto flex w-full flex-col">
            @csrf
            <input type="hidden" name="id_salon" value="{{ $user }}">

            <div class="flex w-full flex-col justify-around">
                <div class="w-full md:grid md:grid-cols-2 md:gap-4 xl:grid-cols-4">
                    <!-- Champs du formulaire -->
                    <input type="hidden" name="lang" value="{{ app()->getLocale() }}">
                    <div class="mb-1">
                        <label
                            class="@error('prenom') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.first_name') }}
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="prenom"
                            class="@error('prenom') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            placeholder=" " value="{{ old('prenom') }}" autocomplete="prenom" required />
                        @error('prenom')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="floating_email"
                            class="@error('email') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.email') }}
                            <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="floating_email"
                            class="@error('email') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('genre_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.gender') }}
                            <span class="text-red-500">*</span></label>
                        <select name="genre_id" id="floating_intitule"
                            class="@error('genre_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($genres->take(3) as $genre)
                                <option value="{{ $genre->id }}">
                                    {{ $genre->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('genre_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="floating_date_naissance"
                            class="@error('date_naissance') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.birth_date') }}
                            <span class="text-red-500">*</span></label>
                        <input type="date" name="date_naissance" id="floating_date_naissance"
                            class="@error('date_naissance') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance"
                            required />
                        @error('date_naissance')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ phoneNumber: '{{ old('telephone') }}', phoneError: '' }">
                        <label class="text-green-gs block text-sm font-medium">
                            {{ __('profile.phone_number') }} <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="phone_input" name="telephone" required x-model="phoneNumber"
                            @input="
                                let digits = $event.target.value.replace(/\D/g, '');
                                if (digits.length <= 10) {
                                    phoneNumber = digits;
                                    phoneError = '';
                                } else {
                                    phoneError = 'Le numéro ne peut pas dépasser 10 chiffres.';
                                }
                            "
                            maxlength="10" pattern="\d{10}" title="Veuillez entrer exactement 10 chiffres"
                            class="focus:border-green-gs focus:ring-green-gs border-supaGirlRose font-roboto-slab mt-1 block w-full rounded-md border-2 text-sm shadow-sm"
                            :class="{ 'border-red-500': phoneError }" />

                        <template x-if="phoneError">
                            <p class="mt-1 text-sm text-red-500" x-text="phoneError"></p>
                        </template>
                    </div>



                    <div class="mb-1">
                        <label
                            class="@error('adresse') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.address') }}</label>
                        <input type="text" name="adresse"
                            class="@error('adresse') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            value="{{ old('adresse') }}">
                        @error('adresse')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('npa') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.zip_code') }}</label>
                        <input type="text" name="npa"
                            class="@error('npa') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            value="{{ old('npa') }}">
                        @error('npa')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('canton') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.canton') }}</label>
                        <select name="canton" id="cantonselect"
                            class="@error('canton') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            onchange="filterVilles()">
                            <option hidden value=""> -- </option>
                            @foreach ($cantons as $canton)
                                <option value="{{ $canton->id }}">{{ $canton->nom }}</option>
                            @endforeach
                        </select>
                        @error('canton')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('ville') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.city') }}</label>
                        <select name="ville" id="villeselect"
                            class="@error('ville') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            onchange="localStorage.setItem('villeNom', this.options[this.selectedIndex].text);">
                            <option hidden value=""> -- </option>
                        </select>
                        @error('ville')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- <div class="mb-1">
                        <label
                            class="@error('categorie') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.category') }}</label>
                        <select name="categorie" id="escort_categorie"
                            class="@error('categorie') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($escortCategories as $categorie)
<option value="{{ $categorie['id'] }}">{{ $categorie['nom'] }}</option>
@endforeach
                        </select>
                        @error('categorie')
    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                        class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
@enderror
                    </div> -->


                    <div class="col-span-2 mb-4 md:col-span-1">
                        <label
                            class="font-roboto-slab text-green-gs block text-sm">{{ __('profile.category') }}</label>
                        <x-select_object_multiple name="categorie" :options="$escortCategories" :value="[]"
                            label="Mes categories" />
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('pratique_sexuelle_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.sexual_practices') }}</label>
                        <select name="pratique_sexuelle_id" id="pratique_sexuelle_id"
                            class="@error('pratique_sexuelle_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($pratiquesSexuelles as $pratique)
                                <option value="{{ $pratique->id }}">
                                    {{ $pratique->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('pratique_sexuelle_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('orientation_sexuelle_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.sexual_orientation') }}</label>
                        <select name="orientation_sexuelle_id" id="orientation_sexuelle_id"
                            class="@error('orientation_sexuelle_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($orientationSexuelles as $oriantation)
                                <option value="{{ $oriantation->id }}">
                                    {{ $oriantation->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('orientation_sexuelle_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('tailles') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.height') }}</label>
                        <input
                            class="@error('tailles') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm"
                            type="number" name="tailles" id="taille" placeholder="taille en cm"
                            value="{{ old('tailles') }}">
                        @error('tailles')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('pubis_type_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.pubic_hair') }}</label>
                        <select id="pubis_type_id" name="pubis_type_id"
                            class="@error('pubis_type_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($pubis as $pubi)
                                <option value="{{ $pubi->id }}">
                                    {{ $pubi->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('pubis_type_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('origine') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.origin') }}</label>
                        <select name="origine" id="origine"
                            class="@error('origine') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($origines as $origine)
                                <option value="{{ $origine }}">{{ $origine }}</option>
                            @endforeach
                        </select>
                        @error('origine')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('couleur_yeux_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.eye_color') }}</label>
                        <select name="couleur_yeux_id" id="couleur_yeux_id"
                            class="@error('couleur_yeux_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($couleursYeux as $yeux)
                                <option value="{{ $yeux->id }}">
                                    {{ $yeux->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('couleur_yeux_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('couleur_cheveux_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.hair_color') }}</label>
                        <select name="couleur_cheveux_id" id="couleur_cheveux_id"
                            class="@error('couleur_cheveux_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($couleursCheveux as $cheveux)
                                <option value="{{ $cheveux->id }}">
                                    {{ $cheveux->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('couleur_cheveux_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('mensuration_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.measurements') }}</label>
                        <select name="mensuration_id" id="mensuration_id"
                            class="@error('mensuration_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($mensurations as $mensuration)
                                <option value="{{ $mensuration->id }}">
                                    {{ $mensuration->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('mensuration_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('poitrine_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.bust') }}</label>
                        <select name="poitrine_id" id="poitrine_id"
                            class="@error('poitrine_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($poitrines as $poitrine)
                                <option value="{{ $poitrine->id }}">
                                    {{ $poitrine->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('poitrine_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>



                    <div class="mb-1">
                        <label
                            class="@error('taille_poitrine') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.bust_size') }}</label>
                        <select id="taille_poitrine" name="taille_poitrine"
                            class="@error('taille_poitrine') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($taillesPoitrine as $taillePoitrine)
                                <option value="{{ $taillePoitrine }}">{{ $taillePoitrine }}</option>
                            @endforeach
                        </select>
                        @error('taille_poitrine')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('tatoo_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.tattoos') }}</label>
                        <select id="tatoo_id" name="tatoo_id"
                            class="@error('tatoo_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($tatouages as $tatou)
                                <option value="{{ $tatou->id }}">
                                    {{ $tatou->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('tatoo_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('mobilite_id') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.mobility') }}</label>
                        <select id="mobilete" name="mobilite_id"
                            class="@error('mobilite_id') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden value=""> -- </option>
                            @foreach ($mobilites as $mobilite)
                                <option value="{{ $mobilite->id }}">
                                    {{ $mobilite->getTranslation('name', app()->getLocale()) }}</option>
                            @endforeach
                        </select>
                        @error('mobilite_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('tarif') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.rate') }}</label>
                        <select id="tarif" name="tarif"
                            class="@error('tarif') border-red-500 @enderror border-supaGirlRose focus:border-green-gs focus:ring-green-gs mt-1 block w-full rounded-md border-2 shadow-sm">
                            <option hidden> -- </option>
                            @foreach ($tarifs as $tarif)
                                <option value="{{ $tarif }}">
                                    {{ __('profile.price_from', ['price' => $tarif]) }}</option>
                            @endforeach
                        </select>
                        @error('tarif')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('paiement') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.payment_method') }}</label>
                        <x-select_multiple name="paiement" :options="$paiements" :value="old('paiement', [])" label="Paiment" />
                        @error('paiement')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="w-full md:grid md:grid-cols-2 md:gap-4">
                    <div class="mb-1">
                        <label
                            class="@error('service') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.services') }}</label>
                        <x-select_object_multiple name="service" :options="$services" :value="old('service', [])"
                            label="Mes services" />
                        @error('service')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('langues') text-red-700 dark:text-red-500 @enderror text-green-gs block text-sm font-medium">{{ __('profile.languages') }}</label>
                        <x-select_multiple name="langues" :options="$langues" :value="old('langues', [])" label="Langue parlée" />
                        @error('langues')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- <div class="mb-1">
                    <label
                        class="@error('apropos') text-red-700 dark:text-red-500 @enderror text-green-gs mb-1 block text-sm font-medium">{{ __('profile.about') }}</label>
                    <textarea rows="5" name="apropos"
                        class="@error('apropos') border-red-500 @enderror border-supaGirlRose focus:border-green-gsfocus:ring-green-gsdark:border-gray-600 dark:focus:border-green-gsdark:focus:ring-amber-500 block w-full rounded-lg border border-2 bg-gray-50 py-2 text-sm text-gray-900 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">{{ old('apropos') }}</textarea>
                    @error('apropos')
    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
@enderror
                </div> -->
                <div class="col-span-2 mb-4">
                    <label
                        class="font-roboto-slab text-green-gs mb-1 block text-sm">{{ __('profile.about') }}</label>
                    <div class="relative" x-data="{
                        aboutText: '{{ addslashes($user->apropos ?? '') }}',
                        showEmojiPicker: false,
                        activeCategory: 'smileys_emotion',
                        searchQuery: '',
                        searchResults: [],
                        allEmojis: [
                            @if (isset($emojiCategories) && count($emojiCategories) > 0) @foreach ($emojiCategories as $category)
                                                @foreach ($category['emojis'] as $emoji)
                                                    {
                                                        char: '{{ $emoji['char'] }}',
                                                        name: '{{ $emoji['name'] }}',
                                                        slug: '{{ $category['slug'] }}',
                                                        category: '{{ $category['name'] }}'
                                                    },
                                                @endforeach
                                            @endforeach @endif
                        ],
                        init() {
                            this.$watch('showEmojiPicker', value => {
                                if (value) {
                                    this.searchQuery = '';
                                    this.searchResults = [];
                                }
                            });
                        },
                        search() {
                            if (!this.searchQuery.trim()) {
                                this.searchResults = [];
                                return;
                            }
                    
                            const query = this.searchQuery.toLowerCase().trim();
                            this.searchResults = this.allEmojis.filter(emoji =>
                                emoji.name.toLowerCase().includes(query)
                            );
                        },
                        insertEmoji(emoji) {
                            const textarea = this.$refs.aboutTextarea;
                            const start = textarea.selectionStart;
                            const end = textarea.selectionEnd;
                            const text = this.aboutText || '';
                            const before = text.substring(0, start);
                            const after = text.substring(end, text.length);
                    
                            this.aboutText = before + emoji + after;
                    
                            // Focus et position du curseur
                            this.$nextTick(() => {
                                const newPos = start + emoji.length;
                                textarea.focus();
                                textarea.setSelectionRange(newPos, newPos);
                            });
                    
                            // this.showEmojiPicker = false;
                        },
                        filteredEmojis() {
                            if (this.searchQuery) {
                                return this.searchResults;
                            }
                            return this.allEmojis.filter(emoji =>
                                emoji.slug === this.activeCategory
                            );
                        }
                    }">
                        <textarea x-ref="aboutTextarea" name="apropos" x-model="aboutText" rows="4"
                            class="border-supaGirlRosePastel/50 font-roboto-slab text-textColorParagraph focus:border-supaGirlRosePastel/50 focus:ring-supaGirlRosePastel/50 block w-full rounded-lg border bg-gray-50 p-3 pr-10 text-sm">{{ $user->apropos ?? '' }}</textarea>

                        <!-- Emoji Picker Button -->
                        <div class="absolute bottom-3 right-3">
                            <button type="button" @click="showEmojiPicker = !showEmojiPicker"
                                class="text-supaGirlRose hover:text-green-gs focus:outline-none"
                                :class="{ 'text-green-gs': showEmojiPicker }">
                                <i class="far fa-smile"></i>
                            </button>

                            <!-- Emoji Picker Dropdown -->
                            <div x-show="showEmojiPicker" @click.away="showEmojiPicker = false"
                                class="absolute bottom-full right-0 z-10 mb-2 w-80 rounded-lg border border-gray-200 bg-white shadow-lg"
                                style="display: none;" x-cloak>
                                <!-- Search Bar -->
                                <div class="border-b border-gray-200 p-2">
                                    <input type="text" x-model="searchQuery" @input="search()"
                                        placeholder="Rechercher des émojis..."
                                        class="border-supaGirlRosePastel focus:border-green-gs focus:ring-green-gs w-full rounded-md border px-3 py-1.5 text-sm focus:outline-none focus:ring-1">
                                </div>

                                <!-- Category Tabs -->
                                <div class="bg-fieldBg flex overflow-x-auto border-b border-gray-200 px-2"
                                    x-show="!searchQuery">
                                    @if (isset($emojiCategories) && count($emojiCategories) > 0)
                                        @foreach ($emojiCategories as $category)
                                            <button type="button"
                                                @click="activeCategory = '{{ $category['slug'] }}'"
                                                :class="{ 'border-b-2 border-green-gs text-green-gs': activeCategory === '{{ $category['slug'] }}', 'text-gray-600 hover:text-gray-800': activeCategory !== '{{ $category['slug'] }}' }"
                                                class="flex-shrink-0 whitespace-nowrap px-4 py-2 text-sm font-medium transition-colors"
                                                :title="'{{ $category['name'] }}'">
                                                {{ $category['emojis'][0]['char'] ?? '' }}
                                            </button>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Emoji Grid -->
                                <div class="h-64 overflow-y-auto p-2">
                                    <template x-if="searchQuery">
                                        <div class="search-results grid grid-cols-8 gap-1">
                                            <template x-for="emoji in searchResults" :key="emoji.char">
                                                <button type="button" @click="insertEmoji(emoji.char)"
                                                    class="flex h-8 w-8 items-center justify-center rounded-md text-xl hover:bg-gray-100"
                                                    :title="emoji.name">
                                                    <span x-text="emoji.char"></span>
                                                </button>
                                            </template>
                                            <div x-show="searchResults.length === 0"
                                                class="col-span-8 p-4 text-center text-gray-500">
                                                Aucun émoji trouvé pour "<span x-text="searchQuery"></span>"
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="!searchQuery">
                                        <div class="emoji-category">
                                            @if (isset($emojiCategories) && count($emojiCategories) > 0)
                                                @foreach ($emojiCategories as $category)
                                                    <div x-show="activeCategory === '{{ $category['slug'] }}'"
                                                        class="space-y-2">
                                                        <h3 class="text-xs font-semibold text-gray-500">
                                                            {{ $category['name'] }}</h3>
                                                        <div class="grid grid-cols-8 gap-1">
                                                            @foreach ($category['emojis'] as $emoji)
                                                                <button type="button"
                                                                    @click="insertEmoji('{{ $emoji['char'] }}')"
                                                                    class="flex h-8 w-8 items-center justify-center rounded-md text-xl hover:bg-gray-100"
                                                                    title="{{ $emoji['name'] }}">
                                                                    {{ $emoji['char'] }}
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="bg-green-gs hover:bg-green-gs/80 focus:ring-green-gs rounded-lg px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">{{ __('profile.create') }}</button>
        </form>
    </div>
</div>

<script>
    // Données des villes disponibles (à générer côté serveur)
    const availableVilles = @json($villes);

    function filterVilles() {

        const selectedCanton = document.getElementById('cantonselect').value;

        const villeSelect = document.getElementById('villeselect');

        // Effacer les options actuelles
        while (villeSelect.firstChild) {
            villeSelect.removeChild(villeSelect.firstChild);
        }

        // Ajouter une option par défaut
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = '--';
        defaultOption.hidden = true;
        villeSelect.appendChild(defaultOption);

        // Filtrer et ajouter les villes correspondantes
        availableVilles.forEach(ville => {
            if (ville.canton_id == selectedCanton) {
                const option = document.createElement('option');
                option.value = ville.id;
                option.text = ville.nom;
                villeSelect.appendChild(option);
            }
        });
    }

    // Vérifiez si le DOM est complètement chargé avant d'ajouter l'écouteur d'événement
    document.addEventListener('DOMContentLoaded', (event) => {
        const cantonSelect = document.getElementById('cantonselect');
        if (cantonSelect) {
            cantonSelect.addEventListener('change', filterVilles);
        }

        // Ajouter l'écouteur d'événement pour la soumission du formulaire
        const form = document.getElementById('createEscorteForm');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Empêcher la soumission par défaut
            submitForm();
        });
    });

    function submitForm() {
        const form = document.getElementById('createEscorteForm');
        const formData = new FormData(form);




        fetch("{{ route('createEscorteBySalon') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 200) {
                    // Rediriger ou afficher un message de succès
                    window.location.href = "{{ route('profile.index') }}";
                } else {
                    // Afficher les erreurs
                    displayErrors(data.errors);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }

    function displayErrors(errors) {
        const form = document.getElementById('createEscorteForm');
        const errorContainer = document.createElement('div');
        errorContainer.className = 'alert alert-danger';
        errorContainer.innerHTML = '<ul>';

        for (const field in errors) {
            const errorMessage = errors[field][0];
            let errorElement = null;

            // Utilisation d'un switch pour sélectionner les éléments en fonction du champ
            switch (field) {
                case 'email':
                    errorElement = document.querySelector(`#floating_email`).closest('.mb-1');
                    break;
                case 'genre':
                    errorElement = document.querySelector(`#floating_intitule`).closest('.mb-1');
                    break;
                case 'telephone':
                    errorElement = document.querySelector(`#phone_input`).closest('.mb-1');
                    break;
                case 'lien_site_web':
                    errorElement = document.querySelector(`#lien_site_web`).closest('.mb-1');
                    break;
                default:
                    errorElement = document.querySelector(`[name="${field}"]`).closest('.mb-1');
                    break;
            }

            // Ajout du message d'erreur si l'élément est trouvé
            if (errorElement) {
                errorElement.innerHTML +=
                    `<p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ __('profile.oops') }}</span> ${errorMessage}</p>`;
            }
        }

        errorContainer.innerHTML += '</ul>';
        form.prepend(errorContainer);
    }
</script>
