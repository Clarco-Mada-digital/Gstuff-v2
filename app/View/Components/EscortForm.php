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
use App\Models\Silhouette;
use App\Models\TaillePoitrine;
use App\Models\PubisType;
use App\Models\Tattoo;
use App\Models\Mobilite;
use App\Models\NombreFille;

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
        $this->genres = Genre::all();
        $this->pratiquesSexuelles = PratiqueSexuelle::all();
        $this->orientationSexuelles = OrientationSexuelle::all();
        $this->origines = ['Africaine', 'Allemande', 'Asiatique', 'Brésilienne', 'Caucasienne', 'Espagnole', 'Européene', 'Française', 'Indienne', 'Italienne', 'Latine', 'Métisse', 'Orientale', 'Russe', 'Suisesse'];
        $this->couleursYeux = CouleurYeux::all();
        $this->couleursCheveux = CouleurCheveux::all();
        $this->mensurations = Mensuration::all();
        $this->poitrines = Poitrine::all();
        $this->taillesPoitrine = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $this->silhouettes = Silhouette::all();
        $this->pubis = PubisType::all();
        $this->tatouages = Tattoo::all();
        $this->mobilites = Mobilite::all();
        $this->paiements = ['CHF', 'Euros', 'Dollars', 'Twint', 'Visa', 'Mastercard', 'American Express', 'Maestro', 'Postfinance', 'Bitcoin'];
        $this->nombreFilles = NombreFille::all();
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
