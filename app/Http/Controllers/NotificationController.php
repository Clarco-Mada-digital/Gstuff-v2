<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications; // Récupérer les notifications de l'utilisateur connecté

        return view('notifications.index', compact('notifications')); // Retourner la vue 'notifications.index' et passer les notifications
    }

public function destroy($iduser)
{
    $user = Auth::user();

    // Vérification de l'authentification avant toute opération
    if (!$user || $user->profile_type !== 'admin') {
        return redirect()->route('login')->with('error', "Vous devez être connecté en tant qu'administrateur pour effectuer cette opération.");
    }
    $iduser = (int) $iduser;

    // Validation de l'entrée
    if (!is_numeric($iduser)) {
        return redirect()->route('users.index')->with('error', "ID utilisateur invalide. Type détecté : $iduserType");
    }

    

    // Utilisation d'une transaction pour garantir l'atomicité des opérations
    DB::transaction(function () use ($iduser) {
        // Supprimer les notifications filtrées
        Notification::whereJsonContains('data->user_id', $iduser)->delete();

        // Mettre à jour le statut de vérification de l'utilisateur
        $userModifier = User::findOrFail($iduser);
        $userModifier->update([
            'profile_verifie' => 'non verifier'
        ]);
    });

    // Retourner une redirection avec un message de succès
    return redirect()->route('users.index')
        ->with('success', "La notification a été supprimée et le statut de l'utilisateur a été mis à jour avec succès.");
}







}
