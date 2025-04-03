<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view articles')->only('index', 'show');
        $this->middleware('permission:create articles')->only('create', 'store');
        $this->middleware('permission:edit articles')->only('edit', 'update');
        $this->middleware('permission:delete articles')->only('destroy');
        $this->middleware('permission:publish articles')->only('publish');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
        return view('articles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ArticleCategory::all();
        $tags = Tag::all();
        return view('articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [        
            'title' => 'required|max:255|unique:articles',
            'slug' => 'required|max:255|unique:articles',
            'content' => 'required',
            'excerpt' => 'nullable',
            'article_category_id' => 'required|exists:article_categories,id',
            'article_user_id' => 'required|exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date|after_or_equal:today'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // Création de l'article avec les données validées
        try {
            $article = Article::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'excerpt' => $request->excerpt,
                'article_category_id' => $request->article_category_id,
                'article_user_id' => $request->article_user_id,
                'is_published' => $request->is_published ? $request->is_published : false,
                'published_at' => $request->published_at,
            ]);
            
            // Synchronisation des tags, si fournis
            if ($request->has('tags')) {
                $article->tags()->sync($request->tags);
            }

            // Retour à la liste des articles avec succès
            return redirect()->route('articles.index')
                            ->with('success', 'Article créé avec succès');
        } catch (\Exception $e) {
            // Gestion des erreurs en cas de problème lors de la création
            die('Une erreur est survenue lors de la création de l\'article.'. $e);
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de l\'article.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $glossaires = Article::all();

        $glossaire = Article::where('slug', '=', $slug)->first();
        
        return view('sp_glossaire', ['glossaire' => $glossaire, 'glossaires'=>$glossaires]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::with('tags', 'category', 'user')->findOrFail($id);
        if (!$article) {
            return redirect()->route('articles.index')->with('error', 'Article non trouvé');
        }
        // Récupération des catégories et des tags
        $categories = ArticleCategory::all();
        $tags = Tag::all();
        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:articles,title,' . $id,
            'slug' => 'required|max:255|unique:articles,slug,' . $id,
            'content' => 'required',
            'excerpt' => 'nullable',
            'article_category_id' => 'required|exists:article_categories,id',
            // 'article_user_id' => 'required|exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_published' => 'boolean',
            // 'published_at' => 'nullable|date|after_or_equal:today'
        ]);
        
        if ($validator->fails()) {
            dd($validator->errors());
            return back()->withErrors($validator)->withInput();
        }
        
        // Mise à jour de l'article avec les données validées
        try {
            $article = Article::findOrFail($id);
            if (!$article) {
                return redirect()->route('articles.index')->with('error', 'Article non trouvé');
            }
            // Vérification de l'utilisateur
            // if ($article->article_user_id !== $request->article_user_id) {
            //     return redirect()->route('articles.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cet article');
            // }
            // Mise à jour de l'article
            $article->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'excerpt' => $request->excerpt,
                'article_user_id' => $article->article_user_id,
                'article_category_id' => $request->article_category_id,
                'is_published' => $request->is_published ? $request->is_published : false,
                // 'published_at' => $request->published_at,
            ]);
            
            // Synchronisation des tags, si fournis
            if ($request->has('tags')) {
                $article->tags()->sync($request->tags);
            }

            // Retour à la liste des articles avec succès
            return redirect()->route('glossaires.show', ['article' => $article->slug])
                            ->with('success', 'Article mis à jour avec succès');
        } catch (\Exception $e) {
            // Gestion des erreurs en cas de problème lors de la mise à jour
            die('Une erreur est survenue lors de la mise à jour de l\'article.'. $e);
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour de l\'article.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
