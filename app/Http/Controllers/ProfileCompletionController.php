<?php

namespace App\Http\Controllers;

use App\Models\Canton; // Assuming you have a Canton model
use App\Models\Ville;   // Assuming you have a Ville model
use App\Models\Categorie;   // Assuming you have a Categorie model
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileCompletionController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $user['canton'] = Canton::where('id', $user->canton)->first() ?? "";
        $user['categorie'] = Categorie::where('id', $user->categorie)->first() ?? "";

        $serviceIds = explode(',', $user->service);
        $user['service'] = Service::whereIn('id', $serviceIds)->get();

        // $user['service'] = $userService;

        // Fetch dropdown data from database (adjust models and queries as needed)
        $escorts = User::where('profile_type', 'escorte')->get(); // Example: Fetch
        $cantons = Canton::all(); // Example: Fetch all cantons
        $villes = Ville::all();   // Example: Fetch all villes

        // You might need to fetch other dropdown data similarly
        $escort_categories = Categorie::where('type', 'escorte')->get();
        $salon_categories = Categorie::where('type', 'salon')->get();
        $services = Service::all();
        $pratiquesSexuelles = ['Gorge Profonde', 'Levrette', '69', 'BDSM'];
        $origines = ['Française', 'Suisse', 'Italienne', 'Africaine'];
        $couleursYeux = ['Marrons', 'Bleus', 'Verts', 'Noirs'];
        $couleursCheveux = ['Blonds', 'Bruns', 'Roux', 'Noirs'];
        $mensurations = ['Fine', 'Normale', 'Ronde', 'Athlétique'];
        $poitrines = ['Naturelle', 'Améliorée', 'Généreuse'];
        $taillesPoitrine = ['A', 'B', 'C', 'D', 'E', 'F'];
        $pubis = ['Rasé', 'Naturel', 'Entretenu'];
        $tatouages = ['Oui', 'Non', 'Quelques-uns'];
        $mobilites = ['Je reçois', 'Je me déplace', 'Les deux'];
        $tarifs = [150, 200, 250, 300];
        $paiements = ['Cash', 'Carte', 'Twint', 'Virement'];
        $langues = ['Français', 'English', 'Italien', 'Espagnol'];
        $nombre_filles = ['1 à 5', '5 à 15', 'plus de 15'];

        return view('auth.profile', [
            'escorts' => $escorts,
            'user' => $user,
            'cantons' => $cantons,
            'villes' => $villes,
            'categories' => $escort_categories,
            'salon_categories' => $salon_categories,
            'services' => $services,
            'pratiquesSexuelles' => $pratiquesSexuelles,
            'origines' => $origines,
            'couleursYeux' => $couleursYeux,
            'couleursCheveux' => $couleursCheveux,
            'mensurations' => $mensurations,
            'poitrines' => $poitrines,
            'taillesPoitrine' => $taillesPoitrine,
            'pubis' => $pubis,
            'tatouages' => $tatouages,
            'mobilites' => $mobilites,
            'tarifs' => $tarifs,
            'paiements' => $paiements,
            'langues' => $langues,
            'nombre_filles' => $nombre_filles,
        ]);
    }
    /**
     * Affiche les données nécessaires pour les selects du formulaire.
     * (Vous devrez adapter ceci pour récupérer vos données dynamiquement)
     */
    public function getDropdownData()
    {
        // Exemple de données statiques, à remplacer par votre logique de récupération de données
        $categories = Categorie::all();
        $pratiquesSexuelles = ['Gorge Profonde', 'Levrette', '69', 'BDSM'];
        $origines = ['Française', 'Suisse', 'Italienne', 'Africaine'];
        $couleursYeux = ['Marrons', 'Bleus', 'Verts', 'Noirs'];
        $couleursCheveux = ['Blonds', 'Bruns', 'Roux', 'Noirs'];
        $mensurations = ['Fine', 'Normale', 'Ronde', 'Athlétique'];
        $poitrines = ['Naturelle', 'Améliorée', 'Généreuse'];
        $taillesPoitrine = ['A', 'B', 'C', 'D', 'E', 'F'];
        $pubis = ['Rasé', 'Naturel', 'Entretenu'];
        $tatouages = ['Oui', 'Non', 'Quelques-uns'];
        $mobilites = ['Je reçois', 'Je me déplace', 'Les deux'];
        $tarifs = ['CHF', 'EUR', 'USD'];
        $paiements = ['Cash', 'Carte', 'Twint', 'Virement'];

        return response()->json([
            'categories' => $categories,
            'pratiquesSexuelles' => $pratiquesSexuelles,
            'origines' => $origines,
            'couleursYeux' => $couleursYeux,
            'couleursCheveux' => $couleursCheveux,
            'mensurations' => $mensurations,
            'poitrines' => $poitrines,
            'taillesPoitrine' => $taillesPoitrine,
            'pubis' => $pubis,
            'tatouages' => $tatouages,
            'mobilites' => $mobilites,
            'tarifs' => $tarifs,
            'paiements' => $paiements,
        ]);
    }


    public function getProfileCompletionPercentage()
    {
        $user = Auth::user();
        $totalFields = 29; // Total number of fields considered for completion
        $completedFields = 0;

        // Fields to consider for profile completion
        $fieldsToCheck = [
            'intitule',
            'nom_proprietaire',
            'pseudo',
            'telephone',
            'adresse',
            'npa',
            'canton',
            'ville',
            'categorie',
            'recrutement',
            'nombre_filles',
            'pratique_sexuelles',
            'tailles',
            'origine',
            'couleur_yeux',
            'couleur_cheveux',
            'mensuration',
            'poitrine',
            'taille_poitrine',
            'pubis',
            'tatouages',
            'mobilite',
            'tarif',
            'langues',
            'paiement',
            'apropos',
            'autre_contact',
            'complement_adresse',
            'lien_site_web',
            'localisation',
        ];

        foreach ($fieldsToCheck as $field) {
            if (!empty($user->$field)) {
                $completedFields++;
            }
        }

        if ($totalFields > 0) {
            $percentage = ($completedFields / $totalFields) * 100;
        } else {
            $percentage = 0; // Avoid division by zero if no fields are considered
        }


        return response()->json(['percentage' => round($percentage)]);
    }

    /**
     * Met à jour le profil de l'utilisateur et retourne le nouveau pourcentage de completion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'intitule' => 'nullable|string|max:255',
            'nom_proprietaire' => 'nullable|string|max:255',
            'pseudo' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'npa' => 'nullable|string|max:10',
            'canton' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'recrutement' => 'nullable|string|max:255',
            'nombre_filles' => 'nullable|string|max:255',
            'pratique_sexuelles' => 'nullable|string|max:255',
            'tailles' => 'nullable|string|max:255',
            'origine' => 'nullable|string|max:255',
            'couleur_yeux' => 'nullable|string|max:255',
            'couleur_cheveux' => 'nullable|string|max:255',
            'mensuration' => 'nullable|string|max:255',
            'poitrine' => 'nullable|string|max:255',
            'taille_poitrine' => 'nullable|string|max:255',
            'pubis' => 'nullable|string|max:255',
            'tatouages' => 'nullable|string|max:255',
            'mobilite' => 'nullable|string|max:255',
            'tarif' => 'nullable|string|max:255',
            'langues' => 'nullable|string|max:255',
            'paiement' => 'nullable|string|max:255',
            'apropos' => 'nullable|string',
            'autre_contact' => 'nullable|string|max:255',
            'complement_adresse' => 'nullable|string|max:255',
            'lien_site_web' => 'nullable|url|max:255',
            'localisation' => 'nullable|string|max:255',
            // Ajoutez les règles de validation pour les autres champs
        ]);

        $user->update($request->all());

        // Recalculate percentage after update
        $percentageResponse = $this->getProfileCompletionPercentage();
        $percentage = $percentageResponse->getData()->percentage;


        return redirect()->route('profile.index')->with('success', 'Profil mis à jour avec succès!')->with('completionPercentage', $percentage);
    }

    public function updatePhoto(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'photo_profil' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
            'photo_couverture' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
        ]);
        if ($request->hasFile('photo_profil') && $request->file('photo_profil')->isValid()) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Générer un nom unique pour la nouvelle photo
            $filename = Str::slug($user->pseudo ?? $user->nom_salon ?? $user->prenom) . '-' . time() . '.' . $request->file('photo_profil')->extension();
            // Stocker la photo
            $request->file('photo_profil')->storeAs('public/avatars', $filename);

            // Mettre à jour la photo de profil de l'utilisateur
            $user->update(['avatar' => $filename]);

            return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
        }
        if ($request->hasFile('photo_couverture') && $request->file('photo_couverture')->isValid()) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->avatar) {
                Storage::delete('public/couvertures/' . $user->couverture_image);
            }

            // Générer un nom unique pour la nouvelle photo
            $filename = Str::slug($user->pseudo ?? $user->nom_salon ?? $user->prenom) . '-' . time() . '.' . $request->file('photo_couverture')->extension();
            // Stocker la photo
            $request->file('photo_couverture')->storeAs('public/couvertures', $filename);

            // Mettre à jour la photo de profil de l'utilisateur
            $user->update(['couverture_image' => $filename]);

            return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
        }

        return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la photo de profil.');
    }
}
