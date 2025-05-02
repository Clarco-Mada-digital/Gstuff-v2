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
        $this->user = $user;
        $this->cantons = Canton::all();
        $this->villes = Ville::all();
        $this->genres = Genre::all();
        $this->escortCategories =  Categorie::where('type', 'escort')->get();
        $this->services = Service::all();
        $this->langues = Langue::all();
        $this->paiements = Paiement::all();
        $this->tarifs = Tarif::all();
        $this->pratiquesSexuelles = PratiqueSexuelle::all();
        $this->orientationSexuelles = OrientationSexuelle::all();
        $this->origines = Origine::all();
        $this->couleursYeux = CouleurYeux::all();
        $this->couleursCheveux = CouleurCheveux::all();
        $this->mensurations = Mensuration::all();
        $this->poitrines = Poitrine::all();
        $this->taillesPoitrine = TaillePoitrine::all();
        $this->pubis = Pubis::all();
        $this->tatouages = Tatouage::all();
        $this->mobilites = Mobilite::all();
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
