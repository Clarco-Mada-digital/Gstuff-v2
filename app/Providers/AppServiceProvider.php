<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // User::observe(UserObserver::class);
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
        
    }
}
