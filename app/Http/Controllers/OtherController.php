<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\OrientationSexuelle;
use App\Models\Silhouette;
use App\Models\Categorie;
use App\Models\NombreFille;
use App\Models\PratiqueSexuelle;
use App\Models\CouleurYeux;
use App\Models\CouleurCheveux;
use App\Models\Mensuration;
use App\Models\Poitrine;
use App\Models\PubisType;
use App\Models\Tattoo;
use App\Models\Mobilite;
use App\Services\DeepLTranslateService;
use App\Helpers\Locales;

class OtherController extends Controller
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
        return view('admin.others.index');
    }


    public function updateItem(Request $request, $type, $id)
    {
        // Détermine le modèle en fonction du type
        if($type == 'pubis'){
            $modelClass = PubisType::class;
        }elseif($type == 'tatouages'){
            $modelClass = Tattoo::class;
        }else{
            $modelClass = $this->getModelClass($type);
        }
        if (!$modelClass) {
            return response()->json(['error' => 'Type invalide'], 400);
        }

        // Récupère l'élément
        $item = $modelClass::findOrFail($id);


        logger()->info($item);
        logger()->info($request->all());
        logger()->info($type);
        
        // Langues cibles pour les traductions
        $locales = Locales::SUPPORTED_CODES;
        $sourceLocale = $request->locale; // Langue source par défaut

    

        // Traduire le contenu dans toutes les langues cibles
        $translatedName = [];
        foreach ($locales as $locale) {
            if ($locale !== $sourceLocale) {
                $translatedName[$locale] = $this->translateService->translate($request->name, $locale);
            }
        }

        if($type == 'categories'){
            $item->setTranslation('nom', $request->locale, $request->name);
            foreach ($translatedName as $locale => $name) {
                $item->setTranslation('nom', $locale, $name);
            }
            $item->display_name = $request->display_name;
            $item->type = $request->type;
            $item->update();
            return response()->json(['success' => true, 'data' => $item]);
        }elseif($type == 'nombreFilles' || $type == 'couleursCheveux' || $type == 'mensurations' || $type == 'poitrines' || $type == 'pubis' || $type == 'tatouages' || $type == 'mobilites'){
            $item->setTranslation('name', $sourceLocale, $request->name);
            foreach ($translatedName as $locale => $name) {
                $item->setTranslation('name', $locale, $name);
            }
            $item->update();
            return response()->json(['success' => true, 'data' => $item]);
        }
        
        
        
        
        else{
            $item->setTranslation('name', $sourceLocale, $request->name);
            foreach ($translatedName as $locale => $name) {
                $item->setTranslation('name', $locale, $name);
            }
            if($type !== 'silhouette' ){
                $item->slug = $request->slug;
            }
            $item->update();
            return response()->json(['success' => true, 'data' => $item]);
        }
        return response()->json(['success' => false]);

    }

    /**
     * Ajoute un nouvel élément.
     */
    public function addItem(Request $request, $type)
    {

        logger()->info($request->all());
        logger()->info($type);
        // Détermine le modèle en fonction du type

        if($type == 'pubis'){
            $modelClass = PubisType::class;
        }elseif($type == 'tatouages'){
            $modelClass = Tattoo::class;
        }else{
            $modelClass = $this->getModelClass($type);
        }
        if (!$modelClass) {
            return response()->json(['error' => 'Type invalide'], 400);
        }

        // Langues cibles pour les traductions
        $locales = Locales::SUPPORTED_CODES;
        $sourceLocale = $request->locale; // Langue source par défaut

    

        // Traduire le contenu dans toutes les langues cibles
        $translatedName = [];
        foreach ($locales as $locale) {
            if ($locale !== $sourceLocale) {
                $translatedName[$locale] = $this->translateService->translate($request->name, $locale);
            }
        }

        // Création du commentaire avec les traductions
        $item = new $modelClass();
        if($type == 'categories'){
            $item->setTranslation('nom', $sourceLocale, $request->name);
            foreach ($translatedName as $locale => $name) {
                $item->setTranslation('nom', $locale, $name);
            }
            $item->display_name = $request->display_name;
            $item->type = $request->type;
            $item->save();
            return response()->json(['success' => true, 'data' => $item]);
        }elseif($type == 'nombreFilles' || $type == "couleursCheveux" || $type == "mensurations" || $type == 'poitrines' || $type == 'pubis' || $type == 'tatouages' || $type == 'mobilites'){
            
            $item->setTranslation('name', $sourceLocale, $request->name);
            foreach ($translatedName as $locale => $name) {
                $item->setTranslation('name', $locale, $name);
            }
            $item->save();
            return response()->json(['success' => true, 'data' => $item]);
        }
        else{
            $item->setTranslation('name', $sourceLocale, $request->name);
            foreach ($translatedName as $locale => $name) {
                $item->setTranslation('name', $locale, $name);
            }
            if($type !== 'silhouette' ){
                $item->slug = $request->slug;
            }
            $item->save();
            return response()->json(['success' => true, 'data' => $item]);
        }
       return response()->json(['success' => false]);
    }

    /**
     * Supprime un élément.
     */
    public function deleteItem($type, $id)
    {
        // Détermine le modèle en fonction du type
        $modelClass = $this->getModelClass($type);
        if (!$modelClass) {
            return response()->json(['error' => 'Type invalide'], 400);
        }

        // Supprime l'élément
        $item = $modelClass::findOrFail($id);
        $item->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Retourne la classe du modèle en fonction du type.
     */
    private function getModelClass($type)
    {
        $models = [
            'genres' => Genre::class,
            'orientationSexuelle' => OrientationSexuelle::class,
            'silhouette' => Silhouette::class,
            'categories' => Categorie::class,
            'nombreFilles' => NombreFille::class,
            'pratiquesSexuelles' => PratiqueSexuelle::class,
            'couleursYeux' => CouleurYeux::class,
            'couleursCheveux' => CouleurCheveux::class,
            'mensurations' => Mensuration::class,
            'poitrines' => Poitrine::class,
            'pubis' => PubisType::class,
            'tatouages' => Tattoo::class,
            'mobilites' => Mobilite::class,
        ];

        return $models[$type] ?? null;
    }
}
