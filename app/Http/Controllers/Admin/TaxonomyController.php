<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\DeepLTranslateService;
use App\Helpers\Locales;
class TaxonomyController extends Controller
{

    
    

    protected $translateService;

    public function __construct(DeepLTranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

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


    public function fetchCategories(Request $request)
    {
        return response()->json([
            'categories' => ArticleCategory::withCount('articles')->get()
        ]);
    }

    public function fetchTags(Request $request)
    {
        return response()->json([
            'tags' => Tag::withCount('articles')->get()
        ]);
    }






    /**
     * Crée une nouvelle catégorie
     */
    public function storeCategory(Request $request)
    {
        // $validated = $this->validateCategory($request);
        $request->validate([
            'id' => 'nullable|exists:article_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lang' => 'required|string',
        ]);

        $slug = Str::slug($request->name);

        // Vérifier si la catégorie existe déjà
        if ($request->id) {
            $category = ArticleCategory::find($request->id);
            if ($category) {

                $verifierSlug = ArticleCategory::where('slug', $slug);

                if ($verifierSlug->id != $request->id) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Une catégorie avec ce nom existe déjà.'
                    ], 422);
                }

                $locales = Locales::SUPPORTED_CODES;
                $sourceLocale = $request['lang']; // Langue source par défaut
                // Traduire le contenu dans toutes les langues cibles
                $translatedContentDescription = [];
                foreach ($locales as $locale) {
                    if ($locale !== $sourceLocale) {
                        $translatedContentDescription[$locale] = $this->translateService->translate($request['description'], $locale);
                    }else{
                        $translatedContentDescription[$locale] = $request['description'];
                    }
                }
                $request['description'] = $translatedContentDescription;

                $translatedContentName = [];
                foreach ($locales as $locale) {
                    if ($locale !== $sourceLocale) {
                        $translatedContentName[$locale] = $this->translateService->translate($request['name'], $locale);
                    }else{
                        $translatedContentName[$locale] = $request['name'];
                    }
                }
                $request['name'] = $translatedContentName;


                $category->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'description' => $request->description ?? null,
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Catégorie mise à jour avec succès',
                    'data' => $category->loadCount('articles')
                ]);
            }
        }else{
            if (ArticleCategory::where('slug', $slug)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Une catégorie avec ce nom existe déjà.'
                ], 422);
            }
            
    
            // Langues cibles pour les traductions
            $locales = Locales::SUPPORTED_CODES;
            $sourceLocale = $request['lang']; // Langue source par défaut
            // Traduire le contenu dans toutes les langues cibles
            $translatedContentDescription = [];
            foreach ($locales as $locale) {
                if ($locale !== $sourceLocale) {
                    $translatedContentDescription[$locale] = $this->translateService->translate($request['description'], $locale);
                }else{
                    $translatedContentDescription[$locale] = $request['description'];
                }
            }
            $request['description'] = $translatedContentDescription;
    
            $translatedContentName = [];
            foreach ($locales as $locale) {
                if ($locale !== $sourceLocale) {
                    $translatedContentName[$locale] = $this->translateService->translate($request['name'], $locale);
                }else{
                    $translatedContentName[$locale] = $request['name'];
                }
            }
            $request['name'] = $translatedContentName;
    
    
    
    
            $category = ArticleCategory::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description ?? null,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Catégorie créée avec succès',
                'data' => $category->loadCount('articles')
            ]);
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
 * Met à jour une catégorie existante
 */
// public function updateCategory(Request $request)
// {
//     // Validation des entrées
//     $validated = $request->validate([
//         'id' => 'required|exists:article_categories,id',
//         'name' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'lang' => 'required|string',
//     ]);

//     $category = ArticleCategory::findOrFail($validated['id']);
//     $slug = Str::slug($validated['name']);

//     // Vérifier si une autre catégorie existe avec le même slug
//     $existingCategory = ArticleCategory::where('slug', $slug)
//         ->where('id', '!=', $category->id)
//         ->first();

//     if ($existingCategory) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Une catégorie avec ce nom existe déjà.'
//         ], 422);
//     }

//     // Récupérer les traductions existantes
//     $locales = Locales::SUPPORTED_CODES;
//     $sourceLocale = $validated['lang'];
    
//     // Décoder les champs JSON s'ils existent
//     $name = is_string($category->name) ? json_decode($category->name, true) : ($category->name ?? []);
//     $description = is_string($category->description) ? json_decode($category->description, true) : ($category->description ?? []);

//     // Mettre à jour les traductions
//     $name[$sourceLocale] = $validated['name'];
//     if (isset($validated['description'])) {
//         $description[$sourceLocale] = $validated['description'];
//     }

//     // Traduire dans les autres langues
//     foreach ($locales as $locale) {
//         if ($locale !== $sourceLocale) {
//             if (!isset($name[$locale])) {
//                 try {
//                     $name[$locale] = $this->translateService->translate(
//                         $validated['name'], 
//                         $sourceLocale, 
//                         $locale
//                     );
//                 } catch (\Exception $e) {
//                     $name[$locale] = $validated['name'];
//                 }
//             }
            
//             if (isset($validated['description']) && !isset($description[$locale])) {
//                 try {
//                     $description[$locale] = $this->translateService->translate(
//                         $validated['description'], 
//                         $sourceLocale, 
//                         $locale
//                     );
//                 } catch (\Exception $e) {
//                     $description[$locale] = $validated['description'] ?? null;
//                 }
//             }
//         }
//     }

//     // Mise à jour de la catégorie
//     $category->update([
//         'name' => $name,
//         'slug' => $slug,
//         'description' => $description,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Catégorie mise à jour avec succès',
//         'data' => $category->loadCount('articles')
//     ]);
// }




// /**
//  * Met à jour une catégorie existante
//  */
// public function updateCategory(Request $request)
// {
//     // Validation des entrées
//     $validated = $request->validate([
//         'id' => 'required|exists:article_categories,id',
//         'name' => 'required|string|max:255',
//         'description' => 'nullable|string',
//         'lang' => 'required|string',
//     ]);

//     $category = ArticleCategory::findOrFail($validated['id']);
//     $slug = Str::slug($validated['name']);

//     // Vérifier si une autre catégorie existe avec le même slug
//     $existingCategory = ArticleCategory::where('slug', $slug)
//         ->where('id', '!=', $category->id)
//         ->first();

//     if ($existingCategory) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Une catégorie avec ce nom existe déjà.'
//         ], 422);
//     }

//     // Récupérer les traductions existantes
//     $locales = Locales::SUPPORTED_CODES;
//     $sourceLocale = $validated['lang'];
//     $name = $category->name ?? [];
//     $description = $category->description ?? [];

//     // Mettre à jour les traductions
//     $name[$sourceLocale] = $validated['name'];
//     if (isset($validated['description'])) {
//         $description[$sourceLocale] = $validated['description'];
//     }

//     // Traduire dans les autres langues
//     foreach ($locales as $locale) {
//         if ($locale !== $sourceLocale) {
//             if (!isset($name[$locale])) {
//                 try {
//                     $name[$locale] = $this->translateService->translate(
//                         $validated['name'], 
//                         $sourceLocale, 
//                         $locale
//                     );
//                 } catch (\Exception $e) {
//                     $name[$locale] = $validated['name'];
//                 }
//             }
            
//             if (isset($validated['description']) && !isset($description[$locale])) {
//                 try {
//                     $description[$locale] = $this->translateService->translate(
//                         $validated['description'], 
//                         $sourceLocale, 
//                         $locale
//                     );
//                 } catch (\Exception $e) {
//                     $description[$locale] = $validated['description'];
//                 }
//             }
//         }
//     }

//     // Mise à jour de la catégorie
//     $category->update([
//         'name' => $name,
//         'slug' => $slug,
//         'description' => $description,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Catégorie mise à jour avec succès',
//         'data' => $category->loadCount('articles')
//     ]);
// }








    /**
     * Met à jour une catégorie existante
     */
    public function updateCategory(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|exists:article_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lang' => 'required|string',
        ]);
        
    
        $category = ArticleCategory::findOrFail($validated['id']);
        $slug = Str::slug($validated['name']);
    
        // Vérifier si une autre catégorie existe avec le même slug
        $existingCategory = ArticleCategory::where('slug', $slug)
            ->where('id', '!=', $category->id)
            ->first();
    
        if ($existingCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Une catégorie avec ce nom existe déjà.'
            ], 422);
        }

        $locales = Locales::SUPPORTED_CODES;
        $sourceLocale = $request['lang']; // Langue source par défaut
        // Traduire le contenu dans toutes les langues cibles
        $translatedContentDescription = [];
        foreach ($locales as $locale) {
            if ($locale !== $sourceLocale) {
                $translatedContentDescription[$locale] = $this->translateService->translate($request['description'], $locale);
            }else{
                $translatedContentDescription[$locale] = $request['description'];
            }
        }
        $request['description'] = $translatedContentDescription;

        $translatedContentName = [];
        foreach ($locales as $locale) {
            if ($locale !== $sourceLocale) {
                $translatedContentName[$locale] = $this->translateService->translate($request['name'], $locale);
            }else{
                $translatedContentName[$locale] = $request['name'];
            }
        }
        $request['name'] = $translatedContentName;


        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description ?? null,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Catégorie mise à jour avec succès',
            'data' => $category->loadCount('articles')
        ]);
    

        // // Vérifier si la catégorie existe déjà
        // if ($request->id) {
        //     // $category = ArticleCategory::find($request->id);
        //     if ($category) {

        //         $verifierSlug = ArticleCategory::where('slug', $slug);

        //         if ($verifierSlug->id != $request->id) {
        //             return response()->json([
        //                 'success' => false,
        //                 'message' => 'Une catégorie avec ce nom existe déjà.'
        //             ], 422);
        //         }

        //         $locales = Locales::SUPPORTED_CODES;
        //         $sourceLocale = $request['lang']; // Langue source par défaut
        //         // Traduire le contenu dans toutes les langues cibles
        //         $translatedContentDescription = [];
        //         foreach ($locales as $locale) {
        //             if ($locale !== $sourceLocale) {
        //                 $translatedContentDescription[$locale] = $this->translateService->translate($request['description'], $locale);
        //             }else{
        //                 $translatedContentDescription[$locale] = $request['description'];
        //             }
        //         }
        //         $request['description'] = $translatedContentDescription;

        //         $translatedContentName = [];
        //         foreach ($locales as $locale) {
        //             if ($locale !== $sourceLocale) {
        //                 $translatedContentName[$locale] = $this->translateService->translate($request['name'], $locale);
        //             }else{
        //                 $translatedContentName[$locale] = $request['name'];
        //             }
        //         }
        //         $request['name'] = $translatedContentName;


        //         $category->update([
        //             'name' => $request->name,
        //             'slug' => $slug,
        //             'description' => $request->description ?? null,
        //         ]);
        //         return response()->json([
        //             'success' => true,
        //             'message' => 'Catégorie mise à jour avec succès',
        //             'data' => $category->loadCount('articles')
        //         ]);
        //     }
        // }
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