<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HomeController extends Controller
{
  public function home()
  {
      $client = new Client();
      $response = $client->get('https://gstuff.ch/wp-json/wp/v2/posts/'); // Remplacez par l'URL de votre API
      $glossaire = json_decode($response->getBody(), true);

      // Limiter le résultat à 4 éléments
      $limitedData = array_slice($glossaire, 0, 10);

      return view('Home', ['glossaire' => $limitedData]);
  }
}
