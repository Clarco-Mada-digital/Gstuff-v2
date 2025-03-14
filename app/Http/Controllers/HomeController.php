<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
  public function home()
  {
      // $client = new Client();
      // $response = $client->get('https://gstuff.ch/wp-json/wp/v2/posts/'); // Remplacez par l'URL de votre API
      // $glossaire = json_decode($response->getBody(), true);

      // Canton
      // $cantonResp = $client->get('https://gstuff.ch/wp-json/wp/v2/canton');
      // $cantons = json_decode($cantonResp->getBody(), true);

      // Les services
      // $servicesResp = $client->get('https://gstuff.ch/wp-json/services/list_service/');
      // $services = json_decode($servicesResp->getBody(), true);

      // Les escortes
      // $escortsResp = $client->get('https://gstuff.ch/wp-json/escorts/tout-escorts/');
      // $escorts = json_decode($escortsResp->getBody(), true);


      // Limiter le résultat à 4 éléments
      // $limitedData = array_slice($glossaire, 0, 10);
      // $limiteCanton = array_slice($apiData['cantons'], 0, 5);

      return view('home');
  }
}
