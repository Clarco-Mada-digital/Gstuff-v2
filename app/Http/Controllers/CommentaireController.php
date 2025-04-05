<?php

namespace App\Http\Controllers;
use App\Models\Commentaire;

use Illuminate\Http\Request;

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
        //
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
