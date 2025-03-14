<?php

namespace App\Http\Controllers;

use App\Models\Canton; // Assuming you have a Canton model
use App\Models\Ville;   // Assuming you have a Ville model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileCompletionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch dropdown data from database (adjust models and queries as needed)
        $cantons = Canton::all(); // Example: Fetch all cantons
        $villes = Ville::all();   // Example: Fetch all villes

        // You might need to fetch other dropdown data similarly
        $categories = ['Category 1', 'Category 2', 'Category 3']; // Example - replace with actual data source
        $pratiquesSexuelles = ['Pratique 1', 'Pratique 2', 'Pratique 3']; // Example
        $tailles = ['Taille 1', 'Taille 2', 'Taille 3']; // Example
        $origines = ['Origine 1', 'Origine 2', 'Origine 3']; // Example
        $couleursYeux = ['Yeux 1', 'Yeux 2', 'Yeux 3']; // Example
        $couleursCheveux = ['Cheveux 1', 'Cheveux 2', 'Cheveux 3']; // Example
        $mensurations = ['Mensuration 1', 'Mensuration 2', 'Mensuration 3']; // Example
        $poitrines = ['Poitrine 1', 'Poitrine 2', 'Poitrine 3']; // Example
        $taillesPoitrine = ['Taille Poitrine 1', 'Taille Poitrine 2', 'Taille Poitrine 3']; // Example
        $pubis = ['Pubis 1', 'Pubis 2', 'Pubis 3']; // Example
        $tatouages = ['Tatouage 1', 'Tatouage 2', 'Tatouage 3']; // Example
        $mobilites = ['Mobile 1', 'Mobile 2', 'Mobile 3']; // Example
        $tarifs = ['Tarif 1', 'Tarif 2', 'Tarif 3']; // Example
        $paiements = ['Paiement 1', 'Paiement 2', 'Paiement 3']; // Example


        return view('auth.profile', [
            'user' => $user,
            'cantons' => $cantons,
            'villes' => $villes,
            'categories' => $categories,
            'pratiquesSexuelles' => $pratiquesSexuelles,
            'tailles' => $tailles,
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
    /**
     * Affiche les données nécessaires pour les selects du formulaire.
     * (Vous devrez adapter ceci pour récupérer vos données dynamiquement)
     */
    public function getDropdownData()
    {
        // Exemple de données statiques, à remplacer par votre logique de récupération de données
        $categories = ['Escort', 'Salon de massage', 'Bar', 'Club'];
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
            'recrutement' => 'nullable|string|max:255',
            'nombre_filles' => 'nullable|integer|min:0',
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
}
