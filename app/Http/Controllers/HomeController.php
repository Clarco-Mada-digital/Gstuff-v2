<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\Ville;

class HomeController extends Controller
{
  public function home()
  {
      // categorie
      $categories = Categorie::all();

      // Canton
      $cantons = Canton::all();

      // Les services
      // $servicesResp = $client->get('https://gstuff.ch/wp-json/services/list_service/');
      // $services = json_decode($servicesResp->getBody(), true);

      // Les escortes
      $escorts = User::where('profile_type', 'escorte')->get();
      foreach ($escorts as $escort) {
        $escort['canton'] = Canton::find($escort->canton);
        $escort['ville'] = Ville::find($escort->ville);
        $escort['categorie'] = Categorie::find($escort->categorie);
        $escort['service'] = Service::find($escort->service);
      }
      // Les salons
      $salons = User::where('profile_type', 'salon')->get();


      // Limiter le résultat à 4 éléments
      // $limitedData = array_slice($glossaire, 0, 10);
      // $limiteCanton = array_slice($apiData['cantons'], 0, 5);

      return view('home', ['cantons'=> $cantons, 'categories'=> $categories, 'escorts'=> $escorts, 'salons' => $salons]);
  }
}
