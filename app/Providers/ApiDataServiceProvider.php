<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;
use App\Models\Canton;
use App\Models\Ville;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ApiDataServiceProvider extends ServiceProvider
{
  protected $baseUrl;
  protected $baseUrlv2;
  protected $Myjton;

  public Function __construct()
  {
    $this->baseUrl = "https://gstuff.ch/wp-json/";
    $this->baseUrl = $this->baseUrl .'wp/v2/';
    $this->Myjton = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2dzdHVmZi5jaCIsImlhdCI6MTczOTg2ODc4NiwibmJmIjoxNzM5ODY4Nzg2LCJleHAiOjE3NDA0NzM1ODYsImRhdGEiOnsidXNlciI6eyJpZCI6IjEyMzQ3NSJ9fX0._B-LGOQ3-wKgVU5ywKN__TYAeHyAqHwXtAcUJWevbWs";
  }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      // Récupérer les données de l'API wordpress
      // Protect $client = new Client();

      // $glossaires = Cache::remember('glossaires', 3600, function(){
      //   $response = Http::get('https://gstuff.ch/wp-json/wp/v2/posts');
      //   return $response->json();
      // });

      // Cantons
      $cantons = Cache::remember('cantons', 3600, function() {
        try {
            return Canton::all();
        } catch (\Exception $e) {
            // Gérer l'exception si la base de données n'est pas accessible
            Log::error('Erreur lors de la récupération des cantons : ' . $e->getMessage());
            return []; // Retourner un tableau vide ou une valeur par défaut
        }
    });      

      // Villes
      $villes = Cache::remember('cantons', 3600, function(){
        try {
          return Ville::all();
        } catch (\Exception $e) {
          // Gérer l'exception si la base de données n'est pas accessible
          Log::error('Erreur lors de la récupération des cantons : ' . $e->getMessage());
          return []; // Retourner un tableau vide ou une valeur par défaut
        }
      });

      // cgv content
      $cgv = Cache::rememberForever('cgv', function () {
        $response = Http::get('https://gstuff.ch/wp-json/wp/v2/pages/1663');
        return $response->json();
      });

      // Organiser les données dans un tableau associatif
      $apiData = [
        // 'glossaires' => $glossaires,
        'cantons' => $cantons,
        'villes' => $villes,
        'cgv' => $cgv,
      ];

      // Partager les données avec toutes les vues
      View::share('apiData', $apiData);
    }
}
