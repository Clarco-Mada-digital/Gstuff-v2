<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Services\DeepLTranslateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
use App\Notifications\NewCommentNotification;

class CommentaireController extends Controller
{
    protected $translateService;

    public function __construct(DeepLTranslateService $translateService)
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
            return redirect()->route('login')->with('error', __('comment.login_required'));
        }

        // Validation des données
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'lang' => 'required|in:fr,en-US,es,de,it' 
        ], [
            'content.required' => __('comment.content.required'),
            'content.string' => __('comment.content.string'),
            'content.max' => __('comment.content.max', ['max' => 500]),
            'lang.required' => __('comment.lang.required'),
            'lang.in' => __('comment.lang.in'),
        ]);

        try {
            // Langues cibles pour les traductions
            $locales = ['fr', 'en-US', 'es', 'de', 'it'];
            $sourceLocale = $validated['lang']; // Langue source par défaut

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
            
            return back()->with('success', __('comment.stored'));
        } catch (\Exception $e) {
            \Log::error('Error storing comment: ' . $e->getMessage());
            return back()->with('error', __('comment.store_error'));
        }
    }

    public function show($id)
    {
        try {
            $commentaire = Commentaire::with('user')->findOrFail($id);

            if (is_null($commentaire->read_at)) {
                $commentaire->read_at = now();
                $commentaire->save();
            }

            return view('admin.commentaires.show', compact('commentaire'));
            
        } catch (\Exception $e) {
            \Log::error('Error showing comment: ' . $e->getMessage());
            return back()->with('error', __('comment.not_found'));
        }
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('comment.login_required'));
        }

        try {
            $commentaire = Commentaire::findOrFail($id);
            $commentaire->delete();

            $commentairesApproved = Commentaire::where('is_approved', true)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->get();

            $commentairesNotApproved = Commentaire::where('is_approved', false)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->get();


            return view('admin.commentaires.index', compact('commentairesApproved', 'commentairesNotApproved'))
                ->with('success', __('comment.deleted'));
                
        } catch (\Exception $e) {
            \Log::error('Error deleting comment: ' . $e->getMessage());
            return back()->with('error', __('comment.delete_error'));
        }
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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('comment.login_required'));
        }

        try {
            $commentaire = Commentaire::findOrFail($id);
            $commentaire->is_approved = true;
            $commentaire->save();

            return redirect()->route('commentaires.index')
                ->with('success', __('comment.approved'));
                
        } catch (\Exception $e) {
            \Log::error('Error approving comment: ' . $e->getMessage());
            return back()->with('error', __('comment.approve_error'));
        }
    }

    public function unreadCommentsCount()
    {
        try {
            // Compter le nombre de commentaires non lus
            $unreadCommentsCount = Commentaire::whereNull('read_at')->count();

            // Retourner une réponse JSON avec le nombre de commentaires non lus
            return response()->json([
                'success' => true,
                'count' => $unreadCommentsCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error getting unread comments count: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting unread comments count',
                'count' => 0
            ], 500);
        }
    }
}
