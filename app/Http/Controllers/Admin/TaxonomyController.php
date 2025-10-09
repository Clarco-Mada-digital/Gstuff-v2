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
            'lang' => 'required|string|in:' . implode(',', Locales::SUPPORTED_CODES),
        ], [
            'name.required' => __('validation.required', ['attribute' => __('taxonomy.fields.name')]),
            'name.string' => __('validation.string', ['attribute' => __('taxonomy.fields.name')]),
            'name.max' => __('validation.max.string', [
                'attribute' => __('taxonomy.fields.name'),
                'max' => 255
            ]),
            'description.string' => __('validation.string', ['attribute' => __('taxonomy.fields.description')]),
            'lang.required' => __('validation.required', ['attribute' => __('taxonomy.fields.language')]),
            'lang.string' => __('validation.string', ['attribute' => __('taxonomy.fields.language')]),
            'lang.in' => __('validation.in', ['attribute' => __('taxonomy.fields.language')]),
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
                        'message' => __('taxonomy.validation.name_exists')
                    ], 422);
                }

                $locales = Locales::SUPPORTED_CODES;
                $sourceLocale = $request['lang']; // Langue source par défaut
                // Traduire le contenu dans toutes les langues cibles
                $translatedContentDescription = [];



                if($request['description']){
                    foreach ($locales as $locale) {
                        if ($locale !== $sourceLocale) {
                            $translatedContentDescription[$locale] = $this->translateService->translate($request['description'], $locale);
                        }else{
                            $translatedContentDescription[$locale] = $request['description'];
                        }
                    }
                    $request['description'] = $translatedContentDescription;
    
                }
               
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
                    'message' => __('taxonomy.category_updated'),
                    'data' => $category->loadCount('articles')
                ]);
            }
        }else{
            if (ArticleCategory::where('slug', $slug)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => __('taxonomy.validation.name_exists')
                ], 422);
            }
            
    
            // Langues cibles pour les traductions
            $locales = Locales::SUPPORTED_CODES;
            $sourceLocale = $request['lang']; // Langue source par défaut
            // Traduire le contenu dans toutes les langues cibles
            $translatedContentDescription = [];
            if($request['description']){
                foreach ($locales as $locale) {
                    if ($locale !== $sourceLocale) {
                        $translatedContentDescription[$locale] = $this->translateService->translate($request['description'], $locale);
                    }else{
                        $translatedContentDescription[$locale] = $request['description'];
                    }
                }
                $request['description'] = $translatedContentDescription;
            }
           
           
    
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
                'message' => __('taxonomy.category_created'),
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
    public function updateCategory(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|exists:article_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lang' => 'required|string|in:' . implode(',', Locales::SUPPORTED_CODES),
        ], [
            'id.required' => __('validation.required', ['attribute' => 'ID']),
            'id.exists' => __('validation.exists', ['attribute' => 'ID']),
            'name.required' => __('validation.required', ['attribute' => __('taxonomy.fields.name')]),
            'name.string' => __('validation.string', ['attribute' => __('taxonomy.fields.name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('taxonomy.fields.name'), 'max' => 255]),
            'description.string' => __('validation.string', ['attribute' => __('taxonomy.fields.description')]),
            'lang.required' => __('validation.required', ['attribute' => __('taxonomy.fields.language')]),
            'lang.string' => __('validation.string', ['attribute' => __('taxonomy.fields.language')]),
            'lang.in' => __('validation.in', ['attribute' => __('taxonomy.fields.language')]),
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
                'message' => __('taxonomy.validation.name_exists')
            ], 422);
        }

        $locales = Locales::SUPPORTED_CODES;
        $sourceLocale = $request['lang']; // Langue source par défaut
        // Traduire le contenu dans toutes les langues cibles
        $translatedContentDescription = [];
        if($request['description']){
            foreach ($locales as $locale) {
                if ($locale !== $sourceLocale) {
                    $translatedContentDescription[$locale] = $this->translateService->translate($request['description'], $locale);
                }else{
                    $translatedContentDescription[$locale] = $request['description'];
                }
            }
            $request['description'] = $translatedContentDescription;

        }
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
            'message' => __('taxonomy.category_updated'),
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
                'message' => __('taxonomy.category_deleted')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('taxonomy.delete_error'),
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
            'message' => __('taxonomy.tag_updated'),
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
                'message' => __('taxonomy.tag_deleted')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('taxonomy.delete_error'),
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
            'lang' => 'required|string|in:' . implode(',', Locales::SUPPORTED_CODES),
        ];

        if ($category) {
            $rules['name'] .= ',' . $category->id;
        }

        return $request->validate($rules, [
            'name.required' => __('validation.required', ['attribute' => __('taxonomy.fields.name')]),
            'name.string' => __('validation.string', ['attribute' => __('taxonomy.fields.name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('taxonomy.fields.name'), 'max' => 255]),
            'name.unique' => __('taxonomy.validation.name_exists'),
            'description.string' => __('validation.string', ['attribute' => __('taxonomy.fields.description')]),
            'lang.required' => __('validation.required', ['attribute' => __('taxonomy.fields.language')]),
            'lang.string' => __('validation.string', ['attribute' => __('taxonomy.fields.language')]),
            'lang.in' => __('validation.in', ['attribute' => __('taxonomy.fields.language')]),
        ]);
    }

    /**
     * Validation des données pour les tags
     */
    protected function validateTag(Request $request, ?Tag $tag = null)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:tags,name',
            'lang' => 'required|string|in:' . implode(',', Locales::SUPPORTED_CODES),
        ];

        if ($tag) {
            $rules['name'] .= ',' . $tag->id;
        }

        return $request->validate($rules, [
            'name.required' => __('validation.required', ['attribute' => __('taxonomy.fields.name')]),
            'name.string' => __('validation.string', ['attribute' => __('taxonomy.fields.name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('taxonomy.fields.name'), 'max' => 255]),
            'name.unique' => __('taxonomy.validation.name_exists'),
            'lang.required' => __('validation.required', ['attribute' => __('taxonomy.fields.language')]),
            'lang.string' => __('validation.string', ['attribute' => __('taxonomy.fields.language')]),
            'lang.in' => __('validation.in', ['attribute' => __('taxonomy.fields.language')]),
        ]);
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
            'message' => __('taxonomy.status_updated'),
            'is_active' => $category->is_active
        ]);
    }
}