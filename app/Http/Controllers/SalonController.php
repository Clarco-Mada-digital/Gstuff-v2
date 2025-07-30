<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Canton;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitation;
use App\Models\Gallery;
use App\Models\Feedback as ModelsFeedback;

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

    $salon['havePrivateGallery'] = Gallery::where('user_id', $salon->id)
    ->where('is_public', false)
    ->exists();

    $salon['haveFeedback'] = ModelsFeedback::where('userToid', $salon->id)
    ->exists();


    $acceptedInvitations = Invitation::where(function ($query) use ($salon) {
      $query->where('inviter_id', $salon->id)
            ->orWhere('invited_id', $salon->id); // Condition "OU" sur inviter_id et invited_id
    })
    ->whereIn('type', ['associe au salon', 'invite par salon', 'creer par salon']) // Types d'invitation
    ->where('accepted', true) // Invitations acceptées
    ->get()
    ->map(function ($invitation) {
        if ($invitation->type === 'associe au salon' || $invitation->type === 'creer par salon') {
            $invitation->load('inviter.cantonget', 'inviter.villeget'); // Chargement des relations pour "associe au salon"
        } elseif ($invitation->type === 'invite par salon') {
            $invitation->load('invited.cantonget', 'invited.villeget'); // Chargement des relations pour "invite par salon"
        }
        return $invitation;
    });
  

    if (Auth::check()) {
      // $user = Auth::user()->load('canton');
      $user = Auth::user();
      if ($salon->id == $user->id)
      {
      return redirect()->route('profile.index');
      }else{
        return view('sp_salon', [
          'salon' => $salon,
          'acceptedInvitations' => $acceptedInvitations,
      ]);
      }
    }
    else
    {
      return view('sp_salon', [
          'salon' => $salon,
          'acceptedInvitations' => $acceptedInvitations,
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
