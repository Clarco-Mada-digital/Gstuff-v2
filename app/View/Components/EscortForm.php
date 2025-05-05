<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Canton;
use App\Models\Ville;
use App\Models\Genre;
use App\Models\Categorie;   // Assuming you have a Categorie model

use App\Models\Service;
use App\Models\Langue;
use App\Models\Paiement;
use App\Models\Tarif;
use App\Models\PratiqueSexuelle;
use App\Models\OrientationSexuelle;
use App\Models\Origine;
use App\Models\CouleurYeux;
use App\Models\CouleurCheveux;
use App\Models\Mensuration;
use App\Models\Poitrine;
use App\Models\TaillePoitrine;
use App\Models\Pubis;
use App\Models\Tatouage;
use App\Models\Mobilite;

class EscortForm extends Component
{
    /**
     * Create a new component instance.
     */
    public $user;
    public $cantons;
    public $villes;
    public $genres;
    public $escortCategories;
    public $services;
    public $langues;
    public $paiements;
    public $tarifs;
    public $pratiquesSexuelles;
    public $orientationSexuelles;
    public $origines;
    public $couleursYeux;
    public $couleursCheveux;
    public $mensurations;
    public $poitrines;
    public $taillesPoitrine;
    public $pubis;
    public $tatouages;
    public $mobilites;

    public function __construct($user)
    {
        $this->escortCategories = Categorie::where('type', 'escort')->get();
        $this->user = $user;
        $this->cantons = Canton::all();
        $this->villes = Ville::all();
        $this->services = Service::all();
        $this->genres = ['Femme', 'Homme', 'Trans', 'Gay', 'Lesbienne', 'Bisexuelle', 'Queer'];
        $this->pratiquesSexuelles = ['69', 'Cunnilingus', 'Ejaculation corps', 'Ejaculation facial', 'Face-sitting', 'Fellation', 'Fétichisme', 'GFE', 'Gorge Profonde', 'Lingerie', 'Massage érotique', 'Rapport sexuel', 'Blow job', 'Hand job'];
        $this->orientationSexuelles = ['Bisexuelle', 'Hétéro', 'Lesbienne', 'Polyamoureux', 'Polyamoureuse', 'Autre'];
        $this->origines = ['Africaine', 'Allemande', 'Asiatique', 'Brésilienne', 'Caucasienne', 'Espagnole', 'Européene', 'Française', 'Indienne', 'Italienne', 'Latine', 'Métisse', 'Orientale', 'Russe', 'Suisesse'];
        $this->couleursYeux = ['Bleus', 'Bruns', 'Bruns clairs', 'Gris', 'Jaunes', 'Marrons', 'Noirs', 'Verts', 'Autre'];
        $this->couleursCheveux = ['Blonds', 'Brune', 'Châtin', 'Gris', 'Noiraude', 'Rousse', 'Autre'];
        $this->mensurations = ['Mince', 'Normale', 'Pulpeuse', 'Ronde', 'Sportive'];
        $this->poitrines = ['Naturelle', 'Améliorée'];
        $this->taillesPoitrine = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $this->silhouette = ['Fine', 'Mince', 'Normale', 'Sportive', 'Pulpeuse', 'Ronde'];
        $this->pubis = ['Entièrement rasé', 'Partiellement rasé', 'Tout naturel'];
        $this->tatouages = ['Avec tattos', 'Sans tatto'];
        $this->mobilites = ['Je reçois', 'Je me déplace'];
        $this->paiements = ['CHF', 'Euros', 'Dollars', 'Twint', 'Visa', 'Mastercard', 'American Express', 'Maestro', 'Postfinance', 'Bitcoin'];
        $this->nombreFilles = ['1 à 5', '5 à 15', 'plus de 15'];
        $this->langues = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];
        $this->tarifs = [100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800];

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.escort-form', [
            'user' => $this->user,
            'cantons' => $this->cantons,
            'villes' => $this->villes,
            'genres' => $this->genres,
            'escortCategories' => $this->escortCategories,
            'services' => $this->services,
            'langues' => $this->langues,
            'paiements' => $this->paiements,
            'tarifs' => $this->tarifs,
            'pratiquesSexuelles' => $this->pratiquesSexuelles,
            'orientationSexuelles' => $this->orientationSexuelles,
            'origines' => $this->origines,
            'couleursYeux' => $this->couleursYeux,
            'couleursCheveux' => $this->couleursCheveux,
            'mensurations' => $this->mensurations,
            'poitrines' => $this->poitrines,
            'taillesPoitrine' => $this->taillesPoitrine,
            'pubis' => $this->pubis,
            'tatouages' => $this->tatouages,
            'mobilites' => $this->mobilites,
        ]);
    }
}
