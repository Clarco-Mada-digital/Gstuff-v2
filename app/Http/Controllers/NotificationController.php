<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications;
        return view('notifications.index', compact('notifications'));
    }

    public function destroy($iduser)
    {
        $user = Auth::user();

        // Vérification de l'authentification
        if (!$user || $user->profile_type !== 'admin') {
            return redirect()->route('login')
                ->with('error', __('notification.errors.unauthorized'));
        }

        // Validation de l'entrée
        try {
            $iduser = (int) $iduser;
            
            if (!is_numeric($iduser)) {
                return redirect()->route('users.index')
                    ->with('error', __('notification.errors.invalid_user_id'));
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
                ->with('success', __('notification.success.notification_deleted'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('users.index')
                ->with('error', __('notification.errors.user_not_found'));
                
        } catch (\Exception $e) {
            Log::error('Error in NotificationController@destroy: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Une erreur est survenue lors du traitement de votre demande.');
        }
    }
}
