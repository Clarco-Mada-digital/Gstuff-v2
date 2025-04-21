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

class HomeController extends Controller
{
  private function getEscorts($escorts)
  {
    $esc = [];

    // Détection du pays via IP
    $position = Location::get(request()->ip());
    $viewerCountry = $position?->countryCode ?? 'FR';

    // dd($viewerCountry);

    foreach ($escorts as $escort) {
        if ($escort->isProfileVisibleTo($viewerCountry)) {
            $esc[] = $escort;
        }
    }

    return $esc;
  }

  public function home()
  {
      // categorie
      $categories = Categorie::where('type', 'escort')->get();

      // Canton
      $cantons = Canton::all();
      $glossaire_category_id = ArticleCategory::where('name', 'LIKE', 'glossaires')->first();
      $glossaires = Article::where('article_category_id', '=', $glossaire_category_id->id)->get();   

      // Les services
      // $servicesResp = $client->get('https://gstuff.ch/wp-json/services/list_service/');
      // $services = json_decode($servicesResp->getBody(), true);

      // Les escortes
      $escorts = User::where('profile_type', 'escorte')->get();
      $escorts = $this->getEscorts($escorts);

      foreach ($escorts as $escort) {
        $escort['canton'] = Canton::find($escort->canton);
        $escort['ville'] = Ville::find($escort->ville);
        $escort['categorie'] = Categorie::find($escort->categorie);
        $escort['service'] = Service::find($escort->service);
        // dd($escort->service);
      }
      // Les salons
      $salons = User::where('profile_type', 'salon')->get();
      $salons = $this->getEscorts($salons);
      foreach ($salons as $salon) {
        $salon['canton'] = Canton::find($salon->canton);
        $salon['ville'] = Ville::find($salon->ville);
        $salon['categorie'] = Categorie::find($salon->categorie);
        $salon['service'] = Service::find($salon->service);
      }

      // dd($escorts);


      // Limiter le résultat à 4 éléments
      // $limitedData = array_slice($glossaire, 0, 10);
      // $limiteCanton = array_slice($apiData['cantons'], 0, 5);

      return view('home', ['cantons'=> $cantons, 'categories'=> $categories, 'escorts'=> $escorts, 'salons' => $salons, 'glossaires' => $glossaires]);
  }
  
}
