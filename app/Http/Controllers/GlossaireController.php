<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GlossaireController extends Controller
{
  public function index()
  {
      $artile_glossaire = ArticleCategory::where('name', 'LIKE', 'glossaires')->first();
      $glossaires = Article::where('article_category', 'LIKE', $artile_glossaire->id)
                          ->with(['category', 'tags'])
                          ->paginate(10);

      return view('glossaire', compact('glossaires'));
  }

  public function item($id){

    $response = Http::get('https://gstuff.ch/wp-json/wp/v2/posts');
    $jsonData = $response->json();

    $filteredData = array_filter($jsonData, function ($item) use ($id) {
      return isset($item['id']) && $item['id'] == $id;
    });

    $filteredData = array_values($filteredData);

    // $glossaires = response()->json($filteredData);
    return view('sp_glossaire', ['glossaire' => $filteredData]);
  }
}
