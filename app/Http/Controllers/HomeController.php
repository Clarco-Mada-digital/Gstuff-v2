<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\Ville;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Nombre d'éléments à afficher pour les glossaires.
     *
     * @var int
     */
    private const GLOSSAIRES_LIMIT = 10;

    /**
     * Détermine si un profil est visible en fonction du pays.
     *
     * @param  \App\Models\User  $escort
     * @param  string|null  $viewerCountry
     * @return bool
     */
    private function isProfileVisibleTo(User $escort, ?string $viewerCountry): bool
    {
        return $escort->isProfileVisibleTo($viewerCountry);
    }

    /**
     * Récupère les escortes filtrées par visibilité.
     *
     * @param  \Illuminate\Support\Collection  $escorts
     * @return \Illuminate\Support\Collection
     */
    private function getVisibleEscorts($escorts): \Illuminate\Support\Collection
    {
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? null;

        return $escorts->filter(function ($escort) use ($viewerCountry) {
            return $this->isProfileVisibleTo($escort, $viewerCountry);
        });
    }

    /**
     * Charge les données associées pour un utilisateur (escorte ou salon).
     *
     * @param  \App\Models\User  $user
     * @return \App\Models\User
     */
    private function loadAssociatedData(User $user): User
    {
        $user->canton = Canton::find($user->canton);
        $user->ville = Ville::find($user->ville);
        $categoriesIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
        $user->categorie = Categorie::whereIn('id', $categoriesIds)->get();
        $serviceIds = explode(',', $user->service);
        $user->service = Service::whereIn('id', $serviceIds)->get();

        return $user;
    }

    /**
     * Affiche la page d'accueil avec les données nécessaires.
     *
     * @return \Illuminate\View\View
     */
    // public function home()
    // {
    //     // Catégories
    //     $categories = Categorie::where('type', 'escort')->get();

    //     // Cantons
    //     $cantons = Canton::all();

    //     // Glossaires (avec mise en cache)
    //     $glossaire_category_id = ArticleCategory::where('slug', 'LIKE', 'glossaires')->first();
    //     $glossaires = Cache::remember('glossaires', 60 * 60, function () use ($glossaire_category_id) {
    //         return Article::where('article_category_id', $glossaire_category_id->id)->limit(self::GLOSSAIRES_LIMIT)->get();
    //     });

    //     // Escortes
    //     $escorts = User::where('profile_type', 'escorte')->get();
    //     $escorts = $this->getVisibleEscorts($escorts);
    //     $escorts = $escorts->map(function ($escort) {
    //         return $this->loadAssociatedData($escort);
    //     });

    //     // Salons
    //     $salons = User::where('profile_type', 'salon')->get();
    //     $salons = $this->getVisibleEscorts($salons);
    //     $salons = $salons->map(function ($salon) {
    //         return $this->loadAssociatedData($salon);
    //     });

    //     return view('home', [
    //         'cantons' => $cantons,
    //         'categories' => $categories,
    //         'escorts' => $escorts,
    //         'salons' => $salons,
    //         'glossaires' => $glossaires,
    //     ]);
    // }

    public function home()
{
    // Catégories
    $categories = Cache::remember('categories', 60 * 60, function () {
        return Categorie::where('type', 'escort')->get();
    });

    // dd($categories);

    // Cantons
    $cantons = Cache::remember('cantons', 60 * 60, function () {
        return Canton::all();
    });

    // Glossaires
    $glossaire_category_id = Cache::remember('glossaire_category_id', 60 * 60, function () {
        return ArticleCategory::where('slug', 'LIKE', 'glossaires')->first();
    });

    $glossaires = Cache::remember('glossaires', 60 * 60, function () use ($glossaire_category_id) {
        return Article::where('article_category_id', $glossaire_category_id->id)->limit(self::GLOSSAIRES_LIMIT)->get();
    });

   // Escortes
   $escorts = Cache::remember('escorts', 60 * 60, function () {
    return User::where('profile_type', 'escorte')->get();
    });

    $escorts = $this->getVisibleEscorts($escorts);
    $escorts = $escorts->map(function ($escort) {
        return $this->loadAssociatedData($escort);
    })->shuffle(); // Randomize the escorts

    // Salons
    $salons = Cache::remember('salons', 60 * 60, function () {
        return User::where('profile_type', 'salon')->get();
    });

    $salons = $this->getVisibleEscorts($salons);
    $salons = $salons->map(function ($salon) {
        return $this->loadAssociatedData($salon);
    })->shuffle(); // Randomize the salons

    return view('home', [
        'cantons' => $cantons,
        'categories' => $categories,
        'escorts' => $escorts,
        'salons' => $salons,
        'glossaires' => $glossaires,
    ]);
}
}
