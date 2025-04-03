<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('admin/api')->group(function () {
    Route::get('/stats', function () {
        return response()->json([
            'articles' => \App\Models\Article::count(),
            'users' => \App\Models\User::count(),
            'comments' => \App\Models\Feedback::count(),
            // 'views' => \App\Models\Article::sum('views')
        ]);
    });

    Route::get('/articles/recent', function () {
        return \App\Models\Article::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'excerpt' => Str::limit(strip_tags($article->excerpt), 100),
                    // 'excerpt' => Str::limit(strip_tags($article->content), 100),
                    'is_published' => $article->is_published,
                    'created_at' => $article->created_at,
                    'user' => [
                        'pseudo' => $article->user->pseudo,
                        'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($article->user->pseudo).'&background=random'
                    ]
                ];
            });
    });

    Route::get('/activity', function () {
        // Implémentez votre logique d'activité récente ici
        return \App\Models\ActivityLog::with('causer')
        ->latest()
        ->take(10)
        ->get()
        ->map(function ($log) {
            return [
                'id' => $log->id,
                'type' => $log->type,
                'description' => $log->description,
                'created_at' => $log->created_at,
                'causer' => [
                    'name' => $log->causer->pseudo,
                    'avatar' => 'https://ui-avatars.com/api/?name='.urlencode($log->causer->pseudo)
                ],
                'item' => $log->data // Données supplémentaires
            ];
        });
    });
});