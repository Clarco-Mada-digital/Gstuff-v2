<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\File;
use App\Services\MediaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // User::observe(UserObserver::class);
        $this->app->singleton(\App\Services\DeepLTranslateService::class, function ($app) {
            return new \App\Services\DeepLTranslateService();
        });

        $this->app->bind(MediaService::class, function ($app) {
            return new MediaService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des permissions : ' . $e->getMessage());
        }

        // Share emoji data with all views
        $emojiPath = database_path('seeders/dataJson/emojis.json');
        if (File::exists($emojiPath)) {
            $emojiData = json_decode(File::get($emojiPath), true);
            
            // Flatten the emoji data for simple access
            $allEmojis = [];
            $categories = [];
            
            foreach ($emojiData as $category) {
                $categoryName = $category['name'];
                $categorySlug = $category['slug'];
                $categoryEmojis = [];
                
                foreach ($category['emojis'] as $emoji) {
                    $allEmojis[] = $emoji['emoji'];
                    $categoryEmojis[] = [
                        'char' => $emoji['emoji'],
                        'name' => $emoji['name'],
                        'slug' => $emoji['slug']
                    ];
                }
                
                $categories[] = [
                    'name' => $categoryName,
                    'slug' => $categorySlug,
                    'emojis' => $categoryEmojis
                ];
            }
            
            View::share('emojiCategories', $categories);
            View::share('allEmojis', $allEmojis);
        } else {
            View::share('emojiCategories', []);
            View::share('allEmojis', []);
        }
    }
}
