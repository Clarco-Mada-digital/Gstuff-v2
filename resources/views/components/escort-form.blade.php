@props(['user'])

<div class="mx-12 h-[90vh] w-full overflow-y-auto rounded-lg bg-white p-6 shadow-lg md:w-[85vw] xl:w-[80vw]">
    <div class="flex w-full flex-col items-center justify-center px-2 py-3">
        <div class="mb-3">
            <h2 class="font-roboto-slab text-green-gs text-center text-2xl font-bold">{{ __('profile.create_new_escort') }}</h2>
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
                            class="@error('prenom') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.first_name') }}
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="prenom"
                            class="@error('prenom') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            placeholder=" " value="{{ old('prenom') }}" autocomplete="prenom" required />
                        @error('prenom')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="floating_email"
                            class="@error('email') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.email') }}
                            <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="floating_email"
                            class="@error('email') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('genre_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.gender') }}
                            <span class="text-red-500">*</span></label>
                        <select name="genre_id" id="floating_intitule"
                            class="@error('genre_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option hidden value=""> -- </option>
                            @foreach ($genres as $genre)
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
                            class="@error('date_naissance') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.birth_date') }}
                            <span class="text-red-500">*</span></label>
                        <input type="date" name="date_naissance" id="floating_date_naissance"
                            class="@error('date_naissance') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance"
                            required />
                        @error('date_naissance')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('telephone') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.phone_number') }}</label>
                        <input type="text" id="phone_input" name="telephone"
                            class="@error('telephone') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            value="{{ old('telephone') }}">
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('adresse') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.address') }}</label>
                        <input type="text" name="adresse"
                            class="@error('adresse') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            value="{{ old('adresse') }}">
                        @error('adresse')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('npa') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.zip_code') }}</label>
                        <input type="text" name="npa"
                            class="@error('npa') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            value="{{ old('npa') }}">
                        @error('npa')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('canton') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.canton') }}</label>
                        <select name="canton" id="cantonselect"
                            class="@error('canton') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
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
                            class="@error('ville') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.city') }}</label>
                        <select name="ville" id="villeselect"
                            class="@error('ville') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            onchange="localStorage.setItem('villeNom', this.options[this.selectedIndex].text);">
                            <option hidden value=""> -- </option>
                        </select>
                        @error('ville')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('categorie') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.category') }}</label>
                        <select name="categorie" id="escort_categorie"
                            class="@error('categorie') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option hidden value=""> -- </option>
                            @foreach ($escortCategories as $categorie)
                                <option value="{{ $categorie['id'] }}">{{ $categorie['nom'] }}</option>
                            @endforeach
                        </select>
                        @error('categorie')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('pratique_sexuelle_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.sexual_practices') }}</label>
                        <select name="pratique_sexuelle_id" id="pratique_sexuelle_id"
                            class="@error('pratique_sexuelle_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('orientation_sexuelle_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.sexual_orientation') }}</label>
                        <select name="orientation_sexuelle_id" id="orientation_sexuelle_id"
                            class="@error('orientation_sexuelle_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('tailles') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.height') }}</label>
                        <input
                            class="@error('tailles') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                            type="number" name="tailles" id="taille" placeholder="taille en cm"
                            value="{{ old('tailles') }}">
                        @error('tailles')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('pubis_type_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.pubic_hair') }}</label>
                        <select id="pubis_type_id" name="pubis_type_id"
                            class="@error('pubis_type_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('origine') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.origin') }}</label>
                        <select name="origine" id="origine"
                            class="@error('origine') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('couleur_yeux_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.eye_color') }}</label>
                        <select name="couleur_yeux_id" id="couleur_yeux_id"
                            class="@error('couleur_yeux_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('couleur_cheveux_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.hair_color') }}</label>
                        <select name="couleur_cheveux_id" id="couleur_cheveux_id"
                            class="@error('couleur_cheveux_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('mensuration_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.measurements') }}</label>
                        <select name="mensuration_id" id="mensuration_id"
                            class="@error('mensuration_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('poitrine_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.bust') }}</label>
                        <select name="poitrine_id" id="poitrine_id"
                            class="@error('poitrine_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('taille_poitrine') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.bust_size') }}</label>
                        <select id="taille_poitrine" name="taille_poitrine"
                            class="@error('taille_poitrine') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('tatoo_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.tattoos') }}</label>
                        <select id="tatoo_id" name="tatoo_id"
                            class="@error('tatoo_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('mobilite_id') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.mobility') }}</label>
                        <select id="mobilete" name="mobilite_id"
                            class="@error('mobilite_id') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('tarif') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.rate') }}</label>
                        <select id="tarif" name="tarif"
                            class="@error('tarif') border-red-500 @enderror mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
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
                            class="@error('paiement') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.payment_method') }}</label>
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
                            class="@error('service') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.services') }}</label>
                        <x-select_object_multiple name="service" :options="$services" :value="old('service', [])"
                            label="Mes services" />
                        @error('service')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label
                            class="@error('langues') text-red-700 dark:text-red-500 @enderror block text-sm font-medium text-gray-700">{{ __('profile.languages') }}</label>
                        <x-select_multiple name="langues" :options="$langues" :value="old('langues', [])" label="Langue parlée" />
                        @error('langues')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                    class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-1">
                    <label
                        class="@error('apropos') text-red-700 dark:text-red-500 @enderror mb-1 block text-sm font-medium text-gray-700">{{ __('profile.about') }}</label>
                    <textarea rows="5" name="apropos"
                        class="@error('apropos') border-red-500 @enderror block w-full rounded-lg border border-gray-300 bg-gray-50 py-2 text-sm text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">{{ old('apropos') }}</textarea>
                    @error('apropos')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ __('profile.oops') }}</span> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="rounded-lg bg-amber-500 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{ __('profile.create') }}</button>
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
