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

    

    public function admin()
    {       
        return view('admin.articles.index', [
            'articles' => Article::with(['category', 'tags', 'user'])
                ->latest()
                ->paginate(10),
            'categories' => ArticleCategory::all(),
            'tags' => Tag::all()
        ]);
    }

    public function updateStatus(Article $article)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.'
                ], 401);
            }
            
            $article->update([
                'is_published' => !$article->is_published
            ]);

            return response()->json([
                'success' => true,
                'is_published' => $article->is_published,
                'message' => $article->is_published 
                    ? __('article.published')
                    : __('article.unpublished')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating article status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the article status.'
            ], 500);
        }
    }

    public function indexJson()
    {
        return response()->json([
            'articles' => Article::with(['category', 'tags', 'user'])
                ->latest()
                ->get()
                ->map(function($article) {
                    return [
                        'id' => $article->id,
                        'title' => $article->title,
                        'user' => [
                            'id' => $article->user->id,
                            'name' => $article->user->pseudo,
                            'avatar_url' => $article->user->avatar
                        ],
                        'categories' => $article->category,
                        'tags' => $article->tags,
                        'created_at' => $article->created_at,
                        'is_published' => $article->is_published
                    ];
                })
        ]);
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
        ], [
            'title.required' => __('article.title.required'),
            'title.max' => __('article.title.max', ['max' => 255]),
            'title.unique' => __('article.title.unique'),
            'slug.required' => __('article.slug.required'),
            'slug.max' => __('article.slug.max', ['max' => 255]),
            'slug.unique' => __('article.slug.unique'),
            'content.required' => __('article.content.required'),
            'article_category_id.required' => __('article.article_category_id.required'),
            'article_category_id.exists' => __('article.article_category_id.exists'),
            'article_user_id.required' => __('article.article_user_id.required'),
            'article_user_id.exists' => __('article.article_user_id.exists'),
            'tags.array' => __('article.tags.array'),
            'tags.*.exists' => __('article.tags.exists'),
            'is_published.boolean' => __('article.is_published.boolean'),
            'published_at.date' => __('article.published_at.date'),
            'published_at.after_or_equal' => __('article.published_at.after_or_equal'),
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
            return redirect()->route('articles.admin')
                            ->with('success', __('article.stored'));
        } catch (\Exception $e) {
            // Gestion des erreurs en cas de problème lors de la création
            \Log::error('Error creating article: ' . $e->getMessage());
            return back()->withErrors(['error' => __('article.store_error')])->withInput();
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
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_published' => 'boolean',
        ], [
            'title.required' => __('article.title.required'),
            'title.max' => __('article.title.max', ['max' => 255]),
            'title.unique' => __('article.title.unique'),
            'slug.required' => __('article.slug.required'),
            'slug.max' => __('article.slug.max', ['max' => 255]),
            'slug.unique' => __('article.slug.unique'),
            'content.required' => __('article.content.required'),
            'article_category_id.required' => __('article.article_category_id.required'),
            'article_category_id.exists' => __('article.article_category_id.exists'),
            'tags.array' => __('article.tags.array'),
            'tags.*.exists' => __('article.tags.exists'),
            'is_published.boolean' => __('article.is_published.boolean'),
        ]);
        
        if ($validator->fails()) {
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
            return redirect()->route('articles.admin')
                            ->with('success', __('article.updated'));
        } catch (\Exception $e) {
            // Gestion des erreurs en cas de problème lors de la mise à jour
            \Log::error('Error updating article: ' . $e->getMessage());
            return back()->withErrors(['error' => __('article.update_error')])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete();
            
            return response()->json([
                'success' => true,
                'message' => __('article.deleted')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting article: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('article.delete_error')
            ], 500);
        }
    }
}
