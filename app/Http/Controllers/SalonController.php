<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Canton;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\Service;


class SalonController extends Controller
{
  public function show($id){

    $salon = User::find($id);

    if ($salon->profile_type != 'salon') {
      return redirect()->route('home');
    }

    $salon['canton'] = Canton::find($salon->canton);
    $salon['ville'] = Ville::find($salon->ville);

    $salon['categories'] = Categorie::find($salon->categorie);
    $salon['service'] = Service::find($salon->service);

    return view('Sp_salon', [
        'salon' => $salon,
    ]);
  }
}
