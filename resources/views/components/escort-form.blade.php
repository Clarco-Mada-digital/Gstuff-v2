@props(['user'])

<div class="bg-white rounded-lg shadow-lg p-6 w-full h-[85vh] md:w-[85vw] xl:w-[80vw] mx-12 overflow-y-auto">
    <div class="w-full py-3 px-2 flex flex-col items-center justify-center">
        <div class="mb-3">
            <h2 class="font-dm-serif text-2xl font-bold text-center">Créer un nouvel escorte</h2>
        </div>

        <form id="createEscorteForm" class="w-full mx-auto flex flex-col">
            @csrf
            <input type="hidden" name="id_salon" value="{{ $user }}">

            <div class="w-full flex flex-col justify-around">
                <div class="w-full md:grid md:grid-cols-2 md:gap-4 xl:grid-cols-3">
                    <!-- Champs du formulaire -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('prenom') text-red-700 dark:text-red-500 @enderror">Prénom*</label>
                        <input type="text" name="prenom" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('prenom') border-red-500 @enderror" placeholder=" " value="{{ old('prenom') }}" autocomplete="prenom" required />
                        @error('prenom')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="floating_email" class="block text-sm font-medium text-gray-700 @error('email') text-red-700 dark:text-red-500 @enderror">Email *</label>
                        <input type="email" name="test" id="floating_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('email') border-red-500 @enderror" placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
                        @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('genre') text-red-700 dark:text-red-500 @enderror">Genre *</label>
                        <select name="genre" id="intitule" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('genre') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($genres as $genre)
                            <option value="{{ $genre }}">{{ $genre }}</option>
                            @endforeach
                        </select>
                        @error('genre')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="floating_date_naissance" class="block text-sm font-medium text-gray-700 @error('date_naissance') text-red-700 dark:text-red-500 @enderror">Date anniversaire *</label>
                        <input type="date" name="date_naissance" id="floating_date_naissance" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('date_naissance') border-red-500 @enderror" placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
                        @error('date_naissance')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('telephone') text-red-700 dark:text-red-500 @enderror">Numéro téléphone</label>
                        <input type="text" id="phone-input" name="telephone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('telephone') border-red-500 @enderror" value="{{ old('telephone') }}">
                        @error('telephone')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('adresse') text-red-700 dark:text-red-500 @enderror">Adresse</label>
                        <input type="text" name="adresse" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('adresse') border-red-500 @enderror" value="{{ old('adresse') }}">
                        @error('adresse')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('npa') text-red-700 dark:text-red-500 @enderror">NPA</label>
                        <input type="text" name="npa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('npa') border-red-500 @enderror" value="{{ old('npa') }}">
                        @error('npa')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('canton') text-red-700 dark:text-red-500 @enderror">Canton</label>
                        <select name="canton" id="cantonselect" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('canton') border-red-500 @enderror" onchange="filterVilles()">
                            <option hidden value=""> -- </option>
                            @foreach ($cantons as $canton)
                            <option value="{{ $canton->id }}">{{ $canton->nom }}</option>
                            @endforeach
                        </select>
                        @error('canton')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('ville') text-red-700 dark:text-red-500 @enderror">Ville</label>
                        <select name="ville" id="villeselect" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('ville') border-red-500 @enderror" onchange="localStorage.setItem('villeNom', this.options[this.selectedIndex].text);">
                            <option hidden value=""> -- </option>
                        </select>
                        @error('ville')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('categorie') text-red-700 dark:text-red-500 @enderror">Catégories</label>
                        <select name="categorie" id="escort_categorie" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('categorie') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($escortCategories as $categorie)
                            <option value="{{ $categorie['id'] }}">{{ $categorie['nom'] }}</option>
                            @endforeach
                        </select>
                        @error('categorie')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('pratique_sexuelles') text-red-700 dark:text-red-500 @enderror">Pratique sexuels</label>
                        <select name="pratique_sexuelles" id="pratique_sexuelles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('pratique_sexuelles') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($pratiquesSexuelles as $pratique)
                            <option value="{{ $pratique }}">{{ $pratique }}</option>
                            @endforeach
                        </select>
                        @error('pratique_sexuelles')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('oriantation_sexuelles') text-red-700 dark:text-red-500 @enderror">Orientation sexuels</label>
                        <select name="oriantation_sexuelles" id="oriantation_sexuelles" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('oriantation_sexuelles') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($orientationSexuelles as $oriantation)
                            <option value="{{ $oriantation }}">{{ $oriantation }}</option>
                            @endforeach
                        </select>
                        @error('oriantation_sexuelles')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('service') text-red-700 dark:text-red-500 @enderror">Services</label>
                        <x-select_object_multiple name="service" :options="$services" :value="old('service', [])" label="Mes services" />
                        @error('service')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('tailles') text-red-700 dark:text-red-500 @enderror">Tailles en cm</label>
                        <input class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('tailles') border-red-500 @enderror" type="number" name="tailles" id="taille" placeholder="taille en cm" value="{{ old('tailles') }}">
                        @error('tailles')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('pubis') text-red-700 dark:text-red-500 @enderror">Poils du pubis</label>
                        <select id="pubis" name="pubis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('pubis') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($pubis as $pubi)
                            <option value="{{ $pubi }}">{{ $pubi }}</option>
                            @endforeach
                        </select>
                        @error('pubis')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('origine') text-red-700 dark:text-red-500 @enderror">Origine</label>
                        <select name="origine" id="origine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('origine') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($origines as $origine)
                            <option value="{{ $origine }}">{{ $origine }}</option>
                            @endforeach
                        </select>
                        @error('origine')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('couleur_yeux') text-red-700 dark:text-red-500 @enderror">Couleur des yeux</label>
                        <select name="couleur_yeux" id="couleur_yeux" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('couleur_yeux') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($couleursYeux as $yeux)
                            <option value="{{ $yeux }}">{{ $yeux }}</option>
                            @endforeach
                        </select>
                        @error('couleur_yeux')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('couleur_cheveux') text-red-700 dark:text-red-500 @enderror">Couleur des cheveux</label>
                        <select name="couleur_cheveux" id="couleur_cheveux" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('couleur_cheveux') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($couleursCheveux as $cheveux)
                            <option value="{{ $cheveux }}">{{ $cheveux }}</option>
                            @endforeach
                        </select>
                        @error('couleur_cheveux')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('mensuration') text-red-700 dark:text-red-500 @enderror">Mensuration</label>
                        <select name="mensuration" id="mensuration" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('mensuration') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($mensurations as $mensuration)
                            <option value="{{ $mensuration }}">{{ $mensuration }}</option>
                            @endforeach
                        </select>
                        @error('mensuration')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('poitrine') text-red-700 dark:text-red-500 @enderror">Poitrine</label>
                        <select name="poitrine" id="poitrine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('poitrine') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($poitrines as $poitrine)
                            <option value="{{ $poitrine }}">{{ $poitrine }}</option>
                            @endforeach
                        </select>
                        @error('poitrine')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('taille_poitrine') text-red-700 dark:text-red-500 @enderror">Taille de poitrine</label>
                        <select id="taille_poitrine" name="taille_poitrine" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('taille_poitrine') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($taillesPoitrine as $taillePoitrine)
                            <option value="{{ $taillePoitrine }}">{{ $taillePoitrine }}</option>
                            @endforeach
                        </select>
                        @error('taille_poitrine')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('tatouages') text-red-700 dark:text-red-500 @enderror">Tatouages</label>
                        <select id="tatouages" name="tatouages" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('tatouages') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($tatouages as $tatou)
                            <option value="{{ $tatou }}">{{ $tatou }}</option>
                            @endforeach
                        </select>
                        @error('tatouages')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('mobilite') text-red-700 dark:text-red-500 @enderror">Mobilité</label>
                        <select id="mobilete" name="mobilite" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('mobilite') border-red-500 @enderror">
                            <option hidden value=""> -- </option>
                            @foreach ($mobilites as $mobilite)
                            <option value="{{ $mobilite }}">{{ $mobilite }}</option>
                            @endforeach
                        </select>
                        @error('mobilite')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('langues') text-red-700 dark:text-red-500 @enderror">Langue</label>
                        <x-select_multiple name="langues" :options="$langues" :value="old('langues', [])" label="Langue parlée" />
                        @error('langues')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('tarif') text-red-700 dark:text-red-500 @enderror">Tarif</label>
                        <select id="tarif" name="tarif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('tarif') border-red-500 @enderror">
                            <option hidden> -- </option>
                            @foreach ($tarifs as $tarif)
                            <option value="{{ $tarif }}">A partir de {{ $tarif }}.-CHF</option>
                            @endforeach
                        </select>
                        @error('tarif')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('paiement') text-red-700 dark:text-red-500 @enderror">Moyen de paiement</label>
                        <x-select_multiple name="paiement" :options="$paiements" :value="old('paiement', [])" label="Paiment" />
                        @error('paiement')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('autre_contact') text-red-700 dark:text-red-500 @enderror">Autre contact</label>
                        <input type="text" name="autre_contact" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('autre_contact') border-red-500 @enderror" value="{{ old('autre_contact') }}" />
                        @error('autre_contact')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('complement_adresse') text-red-700 dark:text-red-500 @enderror">Complement d'adresse</label>
                        <input type="text" name="complement_adresse" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('complement_adresse') border-red-500 @enderror" value="{{ old('complement_adresse') }}" />
                        @error('complement_adresse')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 @error('lien_site_web') text-red-700 dark:text-red-500 @enderror">Lien site web</label>
                        <input type="url" name="lien_site_web" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('lien_site_web') border-red-500 @enderror" value="{{ old('lien_site_web') }}" />
                        @error('lien_site_web')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 @error('apropos') text-red-700 dark:text-red-500 @enderror">Apropos</label>
                        <textarea rows="5" name="apropos" class="py-2 block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 @error('apropos') border-red-500 @enderror">{{ old('apropos') }}</textarea>
                        @error('apropos')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{__('Créer')}}</button>
        </form>
    </div>
</div>

<script>
    // Données des villes disponibles (à générer côté serveur)
    const availableVilles = @json($villes);
    console.log("Villes disponibles:", availableVilles);

    function filterVilles() {
        console.log("Fonction filterVilles appelée");

        const selectedCanton = document.getElementById('cantonselect').value;
        console.log("Canton sélectionné:", selectedCanton);

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
            console.log("Vérification de la ville:", ville);
            if (ville.canton_id == selectedCanton) {
                const option = document.createElement('option');
                option.value = ville.id;
                option.text = ville.nom;
                villeSelect.appendChild(option);
                console.log("Ville ajoutée:", ville.nom);
            }
        });
    }

    // Vérifiez si le DOM est complètement chargé avant d'ajouter l'écouteur d'événement
    document.addEventListener('DOMContentLoaded', (event) => {
        console.log("DOM complètement chargé et analysé");
        const cantonSelect = document.getElementById('cantonselect');
        if (cantonSelect) {
            cantonSelect.addEventListener('change', filterVilles);
        } else {
            console.error("Élément avec l'ID 'cantonselect' non trouvé");
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
            if (data.success) {
                // Rediriger ou afficher un message de succès
                // window.location.href = "{{ route('profile.index') }}";
            } else {
                // Afficher les erreurs
                
                const errorContainer = document.createElement('div');
                errorContainer.className = 'alert alert-danger';
                errorContainer.innerHTML = '<ul>';
                for (const field in data.errors) {
                    const errorMessage = data.errors[field][0];
                console.log(field);
                let errorElement 
                if (field === 'email') {
                    errorElement = document.querySelector(`[id="floating_email"]`).closest('.mb-2');
                    console.log(errorElement);
                }else{
                    errorElement = document.querySelector(`[name="${field}"]`).closest('.mb-2');
                    console.log(errorElement);

                }

                   
                    if (errorElement) {
                        errorElement.innerHTML += `<p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> ${errorMessage}</p>`;
                    }
                }
                errorContainer.innerHTML += '</ul>';
                form.prepend(errorContainer);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
</script>
