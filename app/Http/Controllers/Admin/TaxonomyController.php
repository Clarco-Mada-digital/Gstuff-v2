<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxonomyController extends Controller
{
    /**
     * Affiche l'interface de gestion des taxonomies
     */
    public function index(Request $request)
    {
        if ($request->has('json')) {
            return response()->json([
                'categories' => ArticleCategory::withCount('articles')->get(),
                'tags' => Tag::withCount('articles')->get()
            ]);
        }

        return view('admin.taxonomy.index', [
            'categories' => ArticleCategory::withCount('articles')->get(),
            'tags' => Tag::withCount('articles')->get()
        ]);
    }

    /**
     * Crée une nouvelle catégorie
     */
    public function storeCategory(Request $request)
    {
        $validated = $this->validateCategory($request);

        $category = ArticleCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catégorie créée avec succès',
            'data' => $category->loadCount('articles')
        ]);
    }

    /**
     * Met à jour une catégorie existante
     */
    public function updateCategory(Request $request, ArticleCategory $category)
    {
        $validated = $this->validateCategory($request, $category);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catégorie mise à jour avec succès',
            'data' => $category->loadCount('articles')
        ]);
    }

    /**
     * Supprime une catégorie
     */
    public function destroyCategory(ArticleCategory $category)
    {
        try {
            $category->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'La catégorie "' . $category->name . '" a été supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer la catégorie : ' . $e->getMessage(),
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crée un nouveau tag
     */
    public function storeTag(Request $request)
    {
        $validated = $this->validateTag($request);

        $tag = Tag::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag créé avec succès',
            'data' => $tag->loadCount('articles')
        ]);
    }

    /**
     * Met à jour un tag existant
     */
    public function updateTag(Request $request, Tag $tag)
    {
        $validated = $this->validateTag($request, $tag);

        $tag->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag mis à jour avec succès',
            'data' => $tag->loadCount('articles')
        ]);
    }

    /**
     * Supprime un tag
     */
    public function destroyTag(Tag $tag)
    {
        try {
            $tag->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Le tag "' . $tag->name . '" a été supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer le tag : ' . $e->getMessage(),
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validation des données pour les catégories
     */
    protected function validateCategory(Request $request, ?ArticleCategory $category = null)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ];

        if ($category) {
            $rules['name'] .= ',' . $category->id;
        }

        return $request->validate($rules);
    }

    /**
     * Validation des données pour les tags
     */
    protected function validateTag(Request $request, ?Tag $tag = null)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:tags,name'
        ];

        if ($tag) {
            $rules['name'] .= ',' . $tag->id;
        }

        return $request->validate($rules);
    }

    /**
     * Recherche de catégories/tags pour l'autocomplétion
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $type = $request->input('type', 'category');

        if ($type === 'category') {
            $results = ArticleCategory::where('name', 'like', "%{$query}%")
                ->limit(10)
                ->get(['id', 'name as text']);
        } else {
            $results = Tag::where('name', 'like', "%{$query}%")
                ->limit(10)
                ->get(['id', 'name as text']);
        }

        return response()->json($results);
    }

    /**
     * Toggle le statut actif/inactif d'une catégorie
     */
    public function toggleCategoryStatus(ArticleCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Statut de la catégorie mis à jour',
            'is_active' => $category->is_active
        ]);
    }
}