<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications; // Récupérer les notifications de l'utilisateur connecté

        return view('notifications.index', compact('notifications')); // Retourner la vue 'notifications.index' et passer les notifications
    }
}
