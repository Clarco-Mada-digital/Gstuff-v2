<?php

// namespace App\Http\Controllers;
// use App\Models\Commentaire;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;
// use App\Models\Notification;

// use App\Notifications\NewCommentNotification;


// class CommentaireController extends Controller
// {
//     public function index()
//     {
//         $commentairesApproved = Commentaire::where('is_approved', true)
//             ->orderBy('created_at', 'desc')
//             ->with('user') // Charge les données de l'utilisateur lié
//             ->get();
    
//         $commentairesNotApproved = Commentaire::where('is_approved', false)
//             ->orderBy('created_at', 'desc')
//             ->with('user') // Charge les données de l'utilisateur lié
//             ->get();
    
//         return view('admin.commentaires.index', compact('commentairesApproved', 'commentairesNotApproved'));
//     }

//     public function getCommentApproved()
//     {
//         $commentairesApproved = Commentaire::where('is_approved', true)
//             ->orderBy('created_at', 'desc')
//             ->with('user') // Charge les données de l'utilisateur lié
//             ->get();
    
//         return response()->json($commentairesApproved);
//     }
    
    
    

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
    
//     public function store(Request $request)
//     {
//         // Vérification de l'authentification avant toute opération
//         if (!Auth::check()) {
//             return redirect()->route('login')->with('error', 'Vous devez être connecté pour poster un commentaire.');
//         }

//         // Validation des données
//         $validated = $request->validate([
//             'content' => 'required|string|max:500',
//         ]);

//         // Création du commentaire
//         $commentaire = Commentaire::create([
//             'content' => $validated['content'],
//             'user_id' => Auth::id(),
//         ]);

//         $user = Auth::user();

//         $admin = User::where('profile_type', 'admin')->first();
//         if ($admin) {
//             $admin->notify(new NewCommentNotification($commentaire)); 
//         }
//         return redirect()->route('profile.index')->with('success', 'Commentaire envoyé avec succès.');
//     }
    
//         public function show($id)
//         {
//             $commentaire = Commentaire::with('user')->findOrFail($id);

//             $commentaire->read_at = now();
//             $commentaire->save();


//             return view('admin.commentaires.show', compact('commentaire'));
//         }
        
    
//         public function destroy($id)
//         {
//             $commentaire = Commentaire::findOrFail($id);
        
//             if (!Auth::check()) {
//                 return redirect()->route('login')->with('error', 'Vous devez être connecté pour poster un commentaire.');
//             }

            
//             $commentaire->delete();
//             $commentairesApproved = Commentaire::where('is_approved', true)
//                 ->orderBy('created_at', 'desc')
//                 ->with('user') // Charge les données de l'utilisateur lié
//                 ->get();
        
//             $commentairesNotApproved = Commentaire::where('is_approved', false)
//                 ->orderBy('created_at', 'desc')
//                 ->with('user') // Charge les données de l'utilisateur lié
//                 ->get();
        
//             return view('admin.commentaires.index', compact('commentairesApproved', 'commentairesNotApproved'));}
        
//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }
//     public function approve($id)
//     {
//         $commentaire = Commentaire::findOrFail($id);

//         if (!Auth::check()) {
//             return redirect()->route('login')->with('error','Vous devez être connecté et avoir les droits administrateur pour approuver un commentaire.');
//         }


//         $commentaire->is_approved = true;
//         $commentaire->save();

//         return redirect()->route('commentaires.index')->with('success', 'Commentaire approuvé avec succès.');
//     }

//     public function unreadCommentsCount()
//     {
//         // Compter le nombre de commentaires non lus
//         $unreadCommentsCount = Commentaire::whereNull('read_at')->count();

//         // Retourner une réponse JSON avec le nombre de commentaires non lus
//         return response()->json(['count' => $unreadCommentsCount]);
//     }




   
// }


// app/Http/Controllers/CommentaireController.php
namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Services\GoogleTranslateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
use App\Notifications\NewCommentNotification;

class CommentaireController extends Controller
{
    protected $translateService;

    public function __construct(GoogleTranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

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

    public function create()
    {
        //
    }

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

        // Langues cibles pour les traductions
        $locales = ['fr', 'en', 'es', 'de', 'it'];
        $sourceLocale = 'fr'; // Langue source par défaut

        // Traduire le contenu dans toutes les langues cibles
        $translatedContent = [];
        foreach ($locales as $locale) {
            if ($locale !== $sourceLocale) {
                $translatedContent[$locale] = $this->translateService->translate($validated['content'], $locale);
            }
        }

        // Création du commentaire avec les traductions
        $commentaire = new Commentaire();
        $commentaire->setTranslation('content', $sourceLocale, $validated['content']);
        foreach ($translatedContent as $locale => $content) {
            $commentaire->setTranslation('content', $locale, $content);
        }
        $commentaire->user_id = Auth::id();
        $commentaire->save();

        $user = Auth::user();

        $admin = User::where('profile_type', 'admin')->first();
        if ($admin) {
            $admin->notify(new NewCommentNotification($commentaire));
        }

        return redirect()->route('profile.index')->with('success', 'Commentaire envoyé avec succès.');
    }

    public function show($id)
    {
        $commentaire = Commentaire::with('user')->findOrFail($id);

        $commentaire->read_at = now();
        $commentaire->save();

        return view('admin.commentaires.show', compact('commentaire'));
    }

    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour supprimer un commentaire.');
        }

        $commentaire->delete();
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

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function approve($id)
    {
        $commentaire = Commentaire::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté et avoir les droits administrateur pour approuver un commentaire.');
        }

        $commentaire->is_approved = true;
        $commentaire->save();

        return redirect()->route('commentaires.index')->with('success', 'Commentaire approuvé avec succès.');
    }

    public function unreadCommentsCount()
    {
        // Compter le nombre de commentaires non lus
        $unreadCommentsCount = Commentaire::whereNull('read_at')->count();

        // Retourner une réponse JSON avec le nombre de commentaires non lus
        return response()->json(['count' => $unreadCommentsCount]);
    }
}
