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
        $emojiPath = database_path('seeders/dataJson/data-ordered-emoji.json');
        if (File::exists($emojiPath)) {
            $emojis = json_decode(File::get($emojiPath), true);
            View::share('emojis', $emojis);
        } else {
            View::share('emojis', []);
        }
    }
}
