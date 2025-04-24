<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\SalonEscorte;
use App\Models\Invitation;
use App\Models\Favorite;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Cache;


use App\Models\Message;



use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\EscortInvitationNotification;

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


        $salonAssociers = Invitation::where('invited_id', $escort->id)
        ->where('accepted', true)
        // ->where('type', 'invite par salon')
        ->with(['inviter.cantonget'])
        ->with(['inviter.villeget'])
        ->get();


        if (Auth::check()) {
          // $user = Auth::user()->load('canton');
          $user = Auth::user();
          if ($escort->id == $user->id)
          {
          return redirect()->route('profile.index');
          }else{
            return view('sp_escort', [
              'escort' => $escort,
              'salonAssociers' => $salonAssociers,
          ]);
          }
        }
        else
        {
          return view('sp_escort', [
              'escort' => $escort,
'salonAssociers' => $salonAssociers,
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

  /**
 * Permet à un utilisateur d'inviter des escorts.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
public function inviterEscorte(Request $request)
{
    // Validation des données entrantes
    $validated = $request->validate([
        'escort_ids' => 'required|array', // `escort_ids` doit être un tableau
        'escort_ids.*' => 'integer|exists:users,id', // Chaque élément du tableau doit être un ID valide d'utilisateur
    ]);

    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour inviter des escorts.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Récupérer les utilisateurs avec le profile_type "escorte" à partir des IDs validés
    $escorts = User::whereIn('id', $validated['escort_ids'])
                   ->where('profile_type', 'escorte')
                   ->get();

    // Vérifier si tous les IDs correspondent à des escorts
    if ($escorts->count() !== count($validated['escort_ids'])) {
        return redirect()->back()->with('error', 'Certains utilisateurs sélectionnés ne sont pas des escorts.');
    }

    // Envoyer une invitation et une notification à chaque escort
    foreach ($escorts as $escort) {
      // Vérifier si une invitation existe déjà entre inviter_id et invited_id
      $existingInvitation = Invitation::where('inviter_id', $authUser->id)
          ->where('invited_id', $escort->id)
          ->first();
  
      if (!$existingInvitation) {
          // Enregistrer une invitation dans la base de données
          Invitation::create([
              'inviter_id' => $authUser->id, // ID de l'utilisateur qui envoie l'invitation
              'invited_id' => $escort->id,  // ID de l'escort invité
              'accepted' => false,          // Par défaut, l'invitation est en attente
              'type' => 'invite par salon'
          ]);
  
          // Envoyer une notification à l'escort
          $escort->notify(new EscortInvitationNotification($authUser));
      } else {
          // Optionnel : Log ou message indiquant que l'invitation existe déjà
         
      }
  }
  
    return redirect()->route('profile.index')
    ->with('success', 'Votre demande d\'invitation a été envoyée avec succès!');
}

public function inviterSalon(Request $request)
{
    // Validation des données entrantes
    $validated = $request->validate([
        'salon_ids' => 'required|array', // `escort_ids` doit être un tableau
        'salon_ids.*' => 'integer|exists:users,id', // Chaque élément du tableau doit être un ID valide d'utilisateur
    ]);

    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour inviter des escorts.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Récupérer les utilisateurs avec le profile_type "escorte" à partir des IDs validés
    $escorts = User::whereIn('id', $validated['salon_ids'])
                   ->where('profile_type', 'salon')
                   ->get();

    // Vérifier si tous les IDs correspondent à des escorts
    if ($escorts->count() !== count($validated['salon_ids'])) {
        return redirect()->back()->with('error', 'Certains utilisateurs sélectionnés ne sont pas des escorts.');
    }

    // Envoyer une invitation et une notification à chaque escort
    foreach ($escorts as $escort) {
      // Vérifier si une invitation existe déjà entre inviter_id et invited_id
      $existingInvitation = Invitation::where('invited_id', $authUser->id)
          ->where('inviter_id', $escort->id)
          ->first();
  
      if (!$existingInvitation) {
          // Enregistrer une invitation dans la base de données
          Invitation::create([
              'inviter_id' => $authUser->id, // ID de l'utilisateur qui envoie l'invitation
              'invited_id' => $escort->id,  // ID de l'escort invité
              'accepted' => false,          // Par défaut, l'invitation est en attente
              'type' => 'associe au salon'
          ]);
  
          // Envoyer une notification à l'escort
          $escort->notify(new EscortInvitationNotification($authUser));
      } else {
          // Optionnel : Log ou message indiquant que l'invitation existe déjà
         
      }
  }
  return redirect()->route('profile.index')
  ->with('success', 'Votre demande d\'invitation a été envoyée avec succès!');
  
}

public function accepter($id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Vérifier si l'utilisateur est de type "escorte"
    if ($authUser->profile_type !== 'escorte' && $authUser->profile_type !== 'salon' ) {
        return back()->with('error', 'Seuls les utilisateurs avec un profil "escorte" ou "salon" peuvent accepter des invitations.');
    }

    // Rechercher l'invitation par son ID
    $invitation = Invitation::find($id);

    // Vérifier si l'invitation existe
    if (!$invitation) {
        return back()->with('error', 'Invitation non trouvée.');
    }

    // Marquer l'invitation comme acceptée
    $invitation->accepted = true;
    $invitation->save();

    // Retourner avec un message de succès
    return back()->with('success', 'Invitation acceptée avec succès.');
}


public function refuser($id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Vérifier si l'utilisateur est de type "escorte"
    if ($authUser->profile_type !== 'escorte' && $authUser->profile_type !== 'salon' ) {
        return back()->with('error', 'Seuls les utilisateurs avec un profil "escorte" ou "salon" peuvent accepter des invitations.');
    }

    // Rechercher l'invitation par son ID
    $invitation = Invitation::find($id);

    // Vérifier si l'invitation existe
    if (!$invitation) {
        return back()->with('error', 'Invitation non trouvée.');
    }

    // Marquer l'invitation comme acceptée
    $invitation->accepted = false;
    $invitation->save();

    // Retourner avec un message de succès
    return back()->with('success', 'Invitation refusée avec succès.');
}


public function cancel($id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Vérifier si l'utilisateur est de type "escorte"
    if ($authUser->profile_type !== 'salon' && $authUser->profile_type !== 'escorte') {
        return back()->with('error', 'Seuls les utilisateurs avec un profil "escorte" ou "salon" peuvent accepter ou gérer des invitations.');
    }

    // Récupérer l'invitation et vérifier son existence
    $invitation = Invitation::find($id);
    if (!$invitation) {
        return back()->with('error', 'Invitation non trouvée.');
    }

    // Supprimer l'invitation
    $invitation->delete();

    return back()->with('success', 'Invitation annulée avec succès.');
}




public function gererEscorte(Request $request, $id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $userConnected = Auth::user();

    // Vérifier si l'utilisateur connecté est un salon
    if ($userConnected->profile_type !== 'salon') {
        return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.');
    }

    // Récupérer l'escorte associée
    $salonEscorte = SalonEscorte::where('escorte_id', $id)
                                ->where('salon_id', $userConnected->id)
                                ->first();

    if (!$salonEscorte) {
        return redirect()->back()->with('error', 'Escorte non trouvée ou non associée à votre salon.');
    }

    // Enregistrer le dernier timestamp avant déconnexion
    $user = Auth::user();
    $user->last_seen_at = now();
    $user->save();

    // Supprimer le cache de l'utilisateur
    Cache::forget('user-is-online-' . $user->id);

    // Déconnexion de l'utilisateur actuel
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Récupérer le userEscorte
    $userEscorte = User::findOrFail($id);

    // Connexion du userEscorte
    if (Auth::loginUsingId($userEscorte->id)) {
        $request->session()->regenerate();
        return redirect()->route('profile.index')->with('success',  'Vous êtes maintenant connecté en tant que ' . $userEscorte->prenom);
    }

    return redirect()->route('login')->with('error', 'Échec de l\'authentification.');
}
// public function revenirSalon(Request $request, $id)
// {
//     // Vérification de l'authentification avant toute opération
//     if (!Auth::check()) {
//         return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
//     }

//     // Récupérer l'utilisateur connecté
//     $userConnected = Auth::user();

//     // Vérifier si l'utilisateur connecté est un salon
//     if ($userConnected->profile_type !== 'escorte') {
//         return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.');
//     }

//     // Récupérer l'escorte associée
//     $salonEscorte = SalonEscorte::where('salon_id' , $id)
//                                 ->where('escorte_id', $userConnected->id)
//                                 ->first();

//     if (!$salonEscorte) {
//         return redirect()->back()->with('error', 'Escorte non trouvée ou non associée à votre salon.');
//     }

//     // Enregistrer le dernier timestamp avant déconnexion
//     $user = Auth::user();
//     $user->last_seen_at = now();
//     $user->save();

//     // Supprimer le cache de l'utilisateur
//     Cache::forget('user-is-online-' . $user->id);

//     // Déconnexion de l'utilisateur actuel
//     Auth::logout();
//     $request->session()->invalidate();
//     $request->session()->regenerateToken();

//     // Récupérer le userEscorte
//     $userSalon = User::findOrFail($id);

    
//     if (Auth::loginUsingId($userSalon->id)) {
//         $request->session()->regenerate();
//         return redirect()->route('profile.index')->with('success',  'Vous êtes maintenant connecté en tant que ' . $userSalon->prenom);
//     }

//     return redirect()->route('login')->with('error', 'Échec de l\'authentification.');
// }

public function revenirSalon(Request $request, $id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $userConnected = Auth::user();

  

    // Vérifier si l'utilisateur connecté est une escorte
    if ($userConnected->profile_type !== 'escorte') {
        return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.');
    }

    // Récupérer le salon associé
    $salonEscorte = SalonEscorte::where('salon_id', $id)
                                ->where('escorte_id', $userConnected->id)
                                ->first();

    if (!$salonEscorte) {
        return redirect()->back()->with('error', 'Salon non trouvé ou non associé à votre compte.');
    }

    // Enregistrer le dernier timestamp avant déconnexion
    $userConnected->last_seen_at = now();
    $userConnected->save();

    // Supprimer le cache de l'utilisateur
    Cache::forget('user-is-online-' . $userConnected->id);

    // Déconnexion de l'utilisateur actuel
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Récupérer le salon
    $userSalon = User::find($salonEscorte->salon_id);

    if (!$userSalon) {
        return redirect()->route('login')->with('error', 'Salon non trouvé.');
    }

    // Connexion au salon
    Auth::loginUsingId($userSalon->id);
    $request->session()->regenerate();

    return redirect()->route('profile.index')->with('success', 'Vous êtes maintenant connecté en tant que ' . $userSalon->nom_salon);
}

public function deleteEscorteCreateBySalon($id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $userConnected = Auth::user();

    // Vérifier si l'utilisateur connecté est un salon
    if ($userConnected->profile_type !== 'salon') {
        return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.');
    }

    // Récupérer l'escorte associée
    $salonEscorte = SalonEscorte::where('escorte_id', $id)
                                ->where('salon_id', $userConnected->id)
                                ->first();

    if (!$salonEscorte) {
        return redirect()->back()->with('error', 'Escorte non trouvée ou non associée à votre salon.');
    }

    // Récupérer l'escorte
    $escorte = User::findOrFail($salonEscorte->escorte_id);

    // Récupérer l'invitation existante
    $existingInvitation = Invitation::where('inviter_id', $userConnected->id)
                                    ->where('invited_id', $escorte->id)
                                    ->where('type', 'creer par salon')
                                    ->first();

    if (!$existingInvitation) {
        return redirect()->back()->with('error', 'Escorte non trouvée ou non associée à votre salon.');
    }

    // Supprimer l'invitation, l'association salon-escorte et l'escorte
    $existingInvitation->delete();
    $salonEscorte->delete();
    $escorte->delete();

    // Rediriger avec un message de succès
    return redirect()->route('profile.index')->with('success', 'L\'escorte a été supprimée avec succès.');
}


public function autonomiser($id)
{
    // Vérification de l'authentification
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $userConnected = Auth::user();

    // Vérification des permissions
    if ($userConnected->profile_type !== 'salon') {
        return redirect()->back()->with('error', 'Vous n\'avez pas les droits nécessaires pour effectuer cette action.');
    }

    // Récupérer l'escorte associée au salon
    $salonEscorte = SalonEscorte::where([
        ['escorte_id', '=', $id],
        ['salon_id', '=', $userConnected->id]
    ])->first();

    if (!$salonEscorte) {
        return redirect()->back()->with('error', 'Escorte non trouvée ou non associée à votre salon.');
    }

    // Récupérer l'escorte
    $escorte = User::findOrFail($id);

    // Vérifier si une invitation existante est liée
    $existingInvitation = Invitation::where([
        ['inviter_id', '=', $userConnected->id],
        ['invited_id', '=', $escorte->id],
        ['type', '=', 'creer par salon']
    ])->first();

    if (!$existingInvitation) {
        return redirect()->back()->with('error', 'Aucune invitation trouvée pour cette escorte.');
    }

    // Supprimer les relations et mettre à jour les données
    $existingInvitation->delete();
    $salonEscorte->delete();
    $escorte->update(['createbysalon' => false]);

    // Redirection avec message de succès
    return redirect()->route('profile.index')->with('success', 'L\'escorte a été autonomisée avec succès.');
}

}
