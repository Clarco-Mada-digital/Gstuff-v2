<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Article;
use App\Models\ArticleCategory;

class ActivityLogObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'type' => 'article_created',
            'description' => 'a créé un nouvel article',
            'data' => [
                'article_id' => $article->id,
                'title' => $article->title
            ]
        ]);
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        if ($article->isDirty('category_id')) {
            ActivityLog::create([
                'subject_type' => ArticleCategory::class,
                'subject_id' => $article->category_id,
                'event' => 'attached',
                'parent_type' => Article::class,
                'parent_id' => $article->id,
                'description' => "Catégorie associée à l'article",
            ]);
        }
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
