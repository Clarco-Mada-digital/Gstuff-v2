<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Enregistrer les composants
        $this->loadViewComponentsAs('', [
            // Ajoutez vos composants ici si nécessaire
        ]);
        
        // Charger les vues des composants
        $this->loadViewsFrom(resource_path('views/components'), 'components');
    }
}
