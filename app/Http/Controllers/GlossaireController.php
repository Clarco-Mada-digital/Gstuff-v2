<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GlossaireController extends Controller
{
  public function index()
  {
      // $client = new Client();
      // $response = $client->get('https://gstuff.ch/wp-json/wp/v2/posts/'); // Remplacez par l'URL de votre API
      // $glossaires = json_decode($response->getBody(), true);

      //  // Canton
      //  $cantonResp = $client->get('https://gstuff.ch/wp-json/wp/v2/canton');
      //  $cantons = json_decode($cantonResp->getBody(), true);

      // // Les services
      // $servicesResp = $client->get('https://gstuff.ch/wp-json/services/list_service/');
      // $services = json_decode($servicesResp->getBody(), true);


      // $limiteCanton = array_slice($cantons, 0, 5);

      return view('Glossaire');
  }

  public function item($id){

    $response = Http::get('https://gstuff.ch/wp-json/wp/v2/posts');
    $jsonData = $response->json();

    $filteredData = array_filter($jsonData, function ($item) use ($id) {
      return isset($item['id']) && $item['id'] == $id;
    });

    $filteredData = array_values($filteredData);

    // $glossaires = response()->json($filteredData);
    return view('SpGlossaire', ['glossaire' => $filteredData]);
  }
}
