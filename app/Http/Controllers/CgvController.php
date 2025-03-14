<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CgvController extends Controller
{
  public function index()
  {
      // $client = new Client();
      // $response = $client->get('https://gstuff.ch/wp-json/wp/v2/pages/1663');
      // $cgv = json_decode($response->getBody(), true);

      //  // Canton
      //  $cantonResp = $client->get('https://gstuff.ch/wp-json/wp/v2/canton');
      //  $cantons = json_decode($cantonResp->getBody(), true);

      // // Les services
      // $servicesResp = $client->get('https://gstuff.ch/wp-json/services/list_service/');
      // $services = json_decode($servicesResp->getBody(), true);


      // $limiteCanton = array_slice($cantons, 0, 5);

      return view('Cgv');
  }
}
