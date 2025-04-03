<?php

namespace App\Http\Controllers;

use App\Models\Canton; // Assuming you have a Canton model
use App\Models\Ville;   // Assuming you have a Ville model
use App\Models\Categorie;   // Assuming you have a Categorie model
use App\Models\Message;
use App\Models\Service;
use App\Models\User;
use App\Notifications\ComplementationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileCompletionController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user['canton'] = Canton::where('id', $user->canton)->first() ?? '';
            $user['categorie'] = Categorie::where('id', $user->categorie)->first() ?? null;

            $serviceIds = explode(',', $user->service);
            $user['service'] = Service::whereIn('id', $serviceIds)->get();

            // $user['service'] = $userService;

            // Les escortes
            $escorts = User::where('profile_type', 'escorte')->get();
            foreach ($escorts as $escort) {
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
                $escort['categorie'] = Categorie::find($escort->categorie);
                $escort['service'] = Service::find($escort->service);
                // dd($escort->service);
            }
            $cantons = Canton::all(); // Example: Fetch all cantons
            $villes = Ville::all();   // Example: Fetch all villes

            // You might need to fetch other dropdown data similarly
            $escort_categories = Categorie::where('type', 'escort')->get();
            $salon_categories = Categorie::where('type', 'salon')->get();
            $services = Service::all();
            $genres = ['Femme', 'Homme', 'Trans', 'Gay', 'Lesbienne', 'Bisexuelle', 'Queer'];
            $pratiquesSexuelles = ['69', 'Cunnilingus', 'Ejaculation corps', 'Ejaculation facial', 'Face-sitting', 'Fellation', 'Fétichisme', 'GFE', 'Gorge Profonde', 'Lingerie', 'Massage érotique', 'Rapport sexuel', 'Blow job', 'Hand job'];
            $oriantationSexuelles = ['Bisexuelle', 'Hétéro', 'Lesbienne', 'Polyamoureux', 'Polyamoureuse', 'Autre'];
            $origines = ['Africaine', 'Allemande', 'Asiatique', 'Brésilienne', 'Caucasienne', 'Espagnole', 'Européene', 'Française', 'Indienne', 'Italienne', 'Latine', 'Métisse', 'Orientale', 'Russe', 'Suisesse'];
            $couleursYeux = ['Bleus', 'Bruns', 'Bruns clairs', 'Gris', 'Jaunes', 'Marrons', 'Noirs', 'Verts', 'Autre'];
            $couleursCheveux = ['Blonds', 'Brune', 'Châtin', 'Gris', 'Noiraude', 'Rousse', 'Autre'];
            $mensurations = ['Mince', 'Normale', 'Pulpeuse', 'Ronde', 'Sportive'];
            $poitrines = ['Naturelle', 'Améliorée'];
            $taillesPoitrine = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
            $silhouette = ['Fine', 'Mince', 'Normale', 'Sportive', 'Pulpeuse', 'Ronde'];
            $pubis = ['Entièrement rasé', 'Partiellement rasé', 'Tout naturel'];
            $tatouages = ['Avec tattos', 'Sans tatto'];
            $mobilites = ['Je reçois', 'Je me déplace'];
            $paiements = ['CHF', 'Euros', 'Dollars', 'Twint', 'Visa', 'Mastercard', 'American Express', 'Maestro', 'Postfinance', 'Bitcoin'];
            $nombreFilles = ['1 à 5', '5 à 15', 'plus de 15'];
            $langues = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];
            $tarifs = [100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800];


            // Récupérer les favoris de type "escort"
            $escortFavorites = $user->favorites()->where('profile_type', 'escorte')->get();
            foreach ($escortFavorites as $escort) {
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
                $escort['categorie'] = Categorie::find($escort->categorie);
                $escort['service'] = Service::find($escort->service);
                // dd($escort->service);
            }
            // Récupérer les favoris de type "salon"
            $salonFavorites = $user->favorites()->where('profile_type', 'salon')->get();
            foreach ($salonFavorites as $escort) {
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
                $escort['categorie'] = Categorie::find($escort->categorie);
                $escort['service'] = Service::find($escort->service);
                // dd($escort->service);
            }
            
            $messageNoSeen = Message::where('to_id', Auth::user()->id)
                ->where('seen', 0)->count();   
                
            if ($user->profile_type == 'admin') {
                return view('admin.dashboard', ['user'=>$user]);
            }else{
                return view('auth.profile', [
                    'genres' => $genres,
                    'escorts' => $escorts,
                    'user' => $user,
                    'cantons' => $cantons,
                    'villes' => $villes,
                    'escort_categories' => $escort_categories,
                    'salon_categories' => $salon_categories,
                    'services' => $services,
                    'pratiquesSexuelles' => $pratiquesSexuelles,
                    'oriantationSexuelles' => $oriantationSexuelles,
                    'origines' => $origines,
                    'couleursYeux' => $couleursYeux,
                    'couleursCheveux' => $couleursCheveux,
                    'mensurations' => $mensurations,
                    'poitrines' => $poitrines,
                    'taillesPoitrine' => $taillesPoitrine,
                    'pubis' => $pubis,
                    'silhouette' => $silhouette,
                    'tatouages' => $tatouages,
                    'mobilites' => $mobilites,
                    'tarifs' => $tarifs,
                    'paiements' => $paiements,
                    'langues' => $langues,
                    'nombre_filles' => $nombreFilles,
                    'escortFavorites' => $escortFavorites,
                    'salonFavorites' => $salonFavorites,
                    'messageNoSeen' => $messageNoSeen,
                ]);            
            }
        }else{
            return redirect()->route('home');
        }

    }
    /**
     * Affiche les données nécessaires pour les selects du formulaire.
     * (Vous devrez adapter ceci pour récupérer vos données dynamiquement)
     */
    public function getDropdownData()
    {
        // Exemple de données statiques, à remplacer par votre logique de récupération de données
        $categories = Categorie::all();
        $genres = ['Femme', 'Homme', 'Trans', 'Gay', 'Lesbienne', 'Bisexuelle', 'Queer'];
        $pratiquesSexuelles = ['69', 'Cunnilingus', 'Ejaculation corps', 'Ejaculation facial', 'Face-sitting', 'Fellation', 'Fétichisme', 'GFE', 'Gorge Profonde', 'Lingerie', 'Massage érotique', 'Rapport sexuel', 'Blow job', 'Hand job'];
        $oriantationSexuelles = ['Bisexuelle', 'Hétéro', 'Lesbienne', 'Polyamoureux', 'Polyamoureuse', 'Autre'];
        $origines = ['Africaine', 'Allemande', 'Asiatique', 'Brésilienne', 'Caucasienne', 'Espagnole', 'Européene', 'Française', 'Indienne', 'Italienne', 'Latine', 'Métisse', 'Orientale', 'Russe', 'Suisesse'];
        $couleursYeux = ['Bleus', 'Bruns', 'Bruns clairs', 'Gris', 'Jaunes', 'Marrons', 'Noirs', 'Verts', 'Autre'];
        $couleursCheveux = ['Blonds', 'Brune', 'Châtin', 'Gris', 'Noiraude', 'Rousse', 'Autre'];
        $mensurations = ['Mince', 'Normale', 'Pulpeuse', 'Ronde', 'Sportive'];
        $poitrines = ['Naturelle', 'Améliorée'];
        $taillesPoitrine = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $silhouette = ['Fine', 'Mince', 'Normale', 'Sportive', 'Pulpeuse', 'Ronde'];
        $pubis = ['Entièrement rasé', 'Partiellement rasé', 'Tout naturel'];
        $tatouages = ['Avec tattos', 'Sans tatto'];
        $mobilites = ['Je reçois', 'Je me déplace'];
        $paiements = ['CHF', 'Euros', 'Dollars', 'Twint', 'Visa', 'Mastercard', 'American Express', 'Maestro', 'Postfinance', 'Bitcoin'];
        $nombreFilles = ['1 à 5', '5 à 15', 'plus de 15'];
        $langues = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];
        $tarifs = [100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800];

        return response()->json([
            'genres' => $genres,
            'oriantationSexuelles' => $oriantationSexuelles,
            'silhouette' => $silhouette,
            'categories' => $categories,
            'nombreFilles' => $nombreFilles,
            'pratiquesSexuelles' => $pratiquesSexuelles,
            'origines' => $origines,
            'langues' => $langues,
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
        if($user->profile_type == 'escorte')
        {
            $fieldsToCheck = [
                'intitule',
                'prenom',
                'telephone',
                'adresse',
                'npa',
                'canton',
                'ville',
                'categorie',
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
        }elseif($user->profile_type == 'salon')
        {
            $fieldsToCheck = [
                'intitule',
                'nom_proprietaire',
                'nom_salon',
                'telephone',
                'adresse',
                'npa',
                'canton',
                'ville',
                'categorie',
                'recrutement',
                'nombre_filles',               
                'tarif',
                'langues',
                'paiement',
                'apropos',
                'autre_contact',
                'complement_adresse',
                'lien_site_web',
                'localisation',
            ];
        }else
        {
            $fieldsToCheck = [
                'intitule',
                'pseudo',
                'telephone',
                'adresse',
                'npa',
                'canton',
                'ville',
                'autre_contact',
                'complement_adresse',
                'lien_site_web',
                'localisation',
            ];
        }

        foreach ($fieldsToCheck as $field) {
            if (!empty($user->$field)) {
                $completedFields++;
            }
        }

        if ($fieldsToCheck > 0) {
            $length = count($fieldsToCheck);
            $percentage = ($completedFields / $length) * 100;
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
            'user_name' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'npa' => 'nullable|string|max:10',
            'canton' => 'nullable|numeric',
            'ville' => 'nullable',
            'categorie' => 'nullable',
            'service' => 'nullable',
            'oriantation_sexuelles' => 'nullable|string|max:255',
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
            'lat' => 'nullable|string|max:255',
            'lon' => 'nullable|string|max:255',
            // Ajoutez les règles de validation pour les autres champs
        ]);

        $user->update($request->all());

        // Recalculate percentage after update
        $percentageResponse = $this->getProfileCompletionPercentage();
        $percentage = $percentageResponse->getData()->percentage;

        $user->notify(new ComplementationNotification($percentage));

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
            $filename = Str::slug($user->user_name ?? $user->nom_salon ?? $user->name) . '-' . time() . '.' . $request->file('photo_profil')->extension();
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
            $filename = Str::slug($user->user_name ?? $user->nom_salon ?? $user->name) . '-' . time() . '.' . $request->file('photo_couverture')->extension();
            // Stocker la photo
            $request->file('photo_couverture')->storeAs('public/couvertures', $filename);

            // Mettre à jour la photo de profil de l'utilisateur
            $user->update(['couverture_image' => $filename]);

            return redirect()->back()->with('success', 'Photo de profil mise à jour avec succès.');
        }

        return redirect()->back()->with('error', 'Erreur lors de la mise à jour de la photo de profil.');
    }
}
