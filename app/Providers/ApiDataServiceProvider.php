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

      $glossaires = Cache::remember('glossaires', 3600, function(){
        $response = Http::get('https://gstuff.ch/wp-json/wp/v2/posts');
        return $response->json();
      });

      // Cantons
      $cantons = Cache::remember('cantons', 3600, function(){
        $response = Canton::all();
        return $response;
      });

      // Villes
      $villes = Cache::remember('cantons', 3600, function(){
        $response = Ville::all();
        return $response;
      });

      // les categories
      $categories = Categorie::all();     

      // Les escortes
      $escorts = Cache::remember('escorts', 3600, function(){
        $response = User::where('profile_type', 'escorte')->get();
        return $response;
      });

      // Les salons
      $salons = Cache::remember('salons', 3600, function(){
        $response = Http::get('https://gstuff.ch/wp-json/salons/tout-salons');
        return $response->json();
      });

      // cgv content
      $cgv = Cache::rememberForever('cgv', function () {
        $response = Http::get('https://gstuff.ch/wp-json/wp/v2/pages/1663');
        return $response->json();
      });

      // Users
      // $users = Http::withToken($this->Myjton)->get('https://gstuff.ch/wp-json/wp/v2/users')->json();
      // $users = Http::withHeaders([
      //   'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2dzdHVmZi5jaCIsImlhdCI6MTczOTg2ODc4NiwibmJmIjoxNzM5ODY4Nzg2LCJleHAiOjE3NDA0NzM1ODYsImRhdGEiOnsidXNlciI6eyJpZCI6IjEyMzQ3NSJ9fX0._B-LGOQ3-wKgVU5ywKN__TYAeHyAqHwXtAcUJWevbWs',
      // ])->get('http://gstuff.ch/wp-json/wp/v2/posts')->json();

      // $users = $response->json();

      // Organiser les données dans un tableau associatif
      $apiData = [
        'glossaires' => $glossaires,
        'cantons' => $cantons,
        'villes' => $villes,
        'categories' => $categories,
        'escorts' => $escorts,
        'cgv' => $cgv,
        'salons' => $salons,
      ];

      // Partager les données avec toutes les vues
      View::share('apiData', $apiData);
    }
}
