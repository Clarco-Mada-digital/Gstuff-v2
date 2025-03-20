<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;

class EscortController extends Controller
{
    public function show($id)
    {
        $escort = User::find($id);
        $escort['canton'] = Canton::find($escort->canton);
        $escort['ville'] = Ville::find($escort->ville);

        $escort['categories'] = Categorie::find($escort->categorie);
        $serviceIds = explode(',', $escort->service);
        $escort['service'] = Service::whereIn('id', $serviceIds)->get();
        // $escort['service'] = Service::find($escort->service);

      if ($escort->id == auth()->user()->id)
      {
        return redirect()->route('profile.index');
      }
      else
      {
        return view('Sp_escort', [
            'escort' => $escort,
        ]);
      }

    }

    public function search_escort()
  {
    $categories = Categorie::all();
    $services = Service::all();
    $cantons = Canton::all();
    $villes = Ville::all();
    $escorts = User::where('profile_type', 'escorte')->get();

    foreach ($escorts as $escort) {
      $escort['canton'] = Canton::find($escort->canton);
      $escort['ville'] = Ville::find($escort->ville);
      $escort['categorie'] = Categorie::find($escort->categorie);
      $escort['service'] = Service::find($escort->service);
    }

    return view('search_page_escort', ['cantons'=> $cantons, 'categories'=> $categories, 'escorts' => $escorts]);
  }
}
