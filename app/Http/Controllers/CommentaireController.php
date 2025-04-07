<?php

namespace App\Http\Controllers;
use App\Models\Commentaire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewCommentNotification;


class CommentaireController extends Controller
{
    public function index()
    {
        $commentairesApproved = Commentaire::where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->with('user') // Charge les données de l'utilisateur lié
            ->get();
    
        $commentairesNotApproved = Commentaire::where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->with('user') // Charge les données de l'utilisateur lié
            ->get();
    
        return view('admin.commentaires.index', compact('commentairesApproved', 'commentairesNotApproved'));
    }

    public function getCommentApproved()
    {
        $commentairesApproved = Commentaire::where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->with('user') // Charge les données de l'utilisateur lié
            ->get();
    
        return response()->json($commentairesApproved);
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour poster un commentaire.');
        }

        // Validation des données
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Création du commentaire
        $commentaire = Commentaire::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
        ]);

        $user = Auth::user();

        $admin = User::where('profile_type', 'admin')->first();
        if ($admin) {
            $admin->notify(new NewCommentNotification($commentaire)); 
        }
        return redirect()->route('profile.index')->with('success', 'Commentaire envoyé avec succès.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
