<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Canton;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class SalonController extends Controller
{
  public function show($id){

    $salon = User::find($id);

    if ($salon->profile_type != 'salon') {
      return redirect()->route('home');
    }

    $salon['canton'] = Canton::find($salon->canton);
    $salon['ville'] = Ville::find($salon->ville);

    $salon['categorie'] = Categorie::find($salon->categorie);
    $salon['service'] = Service::find($salon->service);

    if (Auth::check()) {
      // $user = Auth::user()->load('canton');
      $user = Auth::user();
      if ($salon->id == $user->id)
      {
      return redirect()->route('profile.index');
      }
    }
    else
    {
      return view('Sp_salon', [
          'salon' => $salon,
      ]);
    }

  }

  public function search_salon()
  {
    $categories = Categorie::all();
    $services = Service::all();
    $cantons = Canton::all();
    $villes = Ville::all();
    $salons = User::where('profile_type', 'salon')->get();

    foreach ($salons as $salon) {
      $salon['canton'] = Canton::find($salon->canton);
      $salon['ville'] = Ville::find($salon->ville);
      $salon['categorie'] = Categorie::find($salon->categorie);
      $salon['service'] = Service::find($salon->service);
    }

    return view('search_page_salon', ['cantons'=> $cantons, 'categories'=> $categories, 'salons' => $salons]);
  }
}
