<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications; // Récupérer les notifications de l'utilisateur connecté

        return view('notifications.index', compact('notifications')); // Retourner la vue 'notifications.index' et passer les notifications
    }


    public function destroy($idnotif)
{
    $user = Auth::user();

    // Vérification de l'authentification avant toute opération
    if (!$user || $user->profile_type !== 'admin') {
        return redirect()->route('login')->with('error', "Vous devez être connecté en tant qu'administrateur pour inviter des escorts.");
    }

    // Chercher la notification par ID
    $notification = Notification::findOrFail($idnotif);

    // Supprimer la notification
    $notification->delete();

    // Retourner une redirection avec un message de succès
    return redirect()->route('users.index')
        ->with('success', "La notification a été supprimée avec succès.");
}









}
