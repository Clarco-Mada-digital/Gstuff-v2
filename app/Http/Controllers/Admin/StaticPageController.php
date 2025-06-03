<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use App\Services\DeepLTranslateService;
use App\Helpers\Locales;

class StaticPageController extends Controller
{

    protected $translateService;

    public function __construct(DeepLTranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = StaticPage::all();
        return view('admin.static-pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.static-pages.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|alpha_dash|unique:static_pages,slug',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'lang' => 'required|in:fr,en-US,es,de,it' 
        ]);

         // Langues cibles pour les traductions
         $locales = Locales::SUPPORTED_CODES;
         $sourceLocale = $validated['lang']; // Langue source par défaut

         // Traduire le contenu dans toutes les langues cibles
         $translatedContent = [];
         $translatedTitle = [];
         foreach ($locales as $locale) {
             if ($locale !== $sourceLocale) {
                 $translatedContent[$locale] = $this->translateService->translate($validated['content'], $locale);
                 $translatedTitle[$locale] = $this->translateService->translate($validated['title'], $locale);
             }
         }

         $staticPage = new StaticPage();
            $staticPage->setTranslation('content', $sourceLocale, $validated['content']);
            foreach ($translatedContent as $locale => $content) {
                $staticPage->setTranslation('content', $locale, $content);
            }
            $staticPage->setTranslation('title', $sourceLocale, $validated['title']);
            foreach ($translatedTitle as $locale => $title) {
                $staticPage->setTranslation('title', $locale, $title);
            }
            $staticPage->meta_title = $validated['meta_title'];
            $staticPage->meta_description = $validated['meta_description'];
            $staticPage->slug = $validated['slug'];
            $staticPage->save(); 
    
        return redirect()->route('static.index')
            ->with('success', 'Page créée avec succès');
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
        $staticPage = StaticPage::findOrFail($id);
        return view('admin.static-pages.edit', compact('staticPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaticPage $staticPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'lang' => 'required|in:fr,en-US,es,de,it' 
        ]);

        $locales = Locales::SUPPORTED_CODES;
        $sourceLocale = $validated['lang']; // Langue source par défaut

        // Traduire le contenu dans toutes les langues cibles
        $translatedContent = [];
        $translatedTitle = [];
        foreach ($locales as $locale) {
            if ($locale !== $sourceLocale) {
                $translatedContent[$locale] = $this->translateService->translate($validated['content'], $locale);
                $translatedTitle[$locale] = $this->translateService->translate($validated['title'], $locale);
            }
        }

        $staticPage->setTranslation('content', $sourceLocale, $validated['content']);
        foreach ($translatedContent as $locale => $content) {
            $staticPage->setTranslation('content', $locale, $content);
        }
        $staticPage->setTranslation('title', $sourceLocale, $validated['title']);
        foreach ($translatedTitle as $locale => $title) {
            $staticPage->setTranslation('title', $locale, $title);
        }
        $staticPage->meta_title = $validated['meta_title'];
        $staticPage->meta_description = $validated['meta_description'];
        $staticPage->save();

        return redirect()->route('static.index')
            ->with('success', 'Page mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
