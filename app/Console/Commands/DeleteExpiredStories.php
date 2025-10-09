<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Story;
use Carbon\Carbon;

class DeleteExpiredStories extends Command
{

    /**
     * Documentation d'utilisation de la commande
     * 
     * Environnement de développement local :
     * - Pour un test ponctuel : php artisan stories:delete-expired
     * - Pour tester la planification : php artisan schedule:work
     * 
     * En production (Linux/Unix) :
     * 1. Ouvrir le crontab : crontab -e
     * 2. Ajouter la ligne suivante (remplacer /chemin/vers/votre/projet) :
     *    * * * * * cd /chemin/vers/votre/projet && php artisan schedule:run >> /dev/null 2>&1
     * 
     * Vérifier les logs :
     * - storage/logs/story-cleanup.log : Sortie de la commande
     * - storage/logs/laravel.log : Erreurs éventuelles
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stories:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprime automatiquement les stories dont la date d\'expiration est dépassée';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       
        $now = Carbon::now();
        $this->info($now);
        $expiredStories = Story::where('expires_at', '<=', $now)->get();
        $this->info($expiredStories);
        $count = $expiredStories->count();

        if ($count === 0) {
            $this->info('Aucune story expirée à supprimer.');
            return 0;
        }

        $this->info("Suppression de {$count} stories expirées...");

        $deletedCount = 0;
        
        foreach ($expiredStories as $story) {
            try {
                // Supprimer le fichier associé s'il existe
                if (Storage::disk('public')->exists($story->media_path)) {
                    Storage::disk('public')->delete($story->media_path);
                }
                
                // Supprimer l'entrée en base de données
                $story->delete();
                $deletedCount++;
                
                $this->line("Story #{$story->id} supprimée");
            } catch (\Exception $e) {
                $this->error("Erreur lors de la suppression de la story #{$story->id}: " . $e->getMessage());
            }
        }

        $this->info("\nTerminé ! {$deletedCount}/{$count} stories expirées ont été supprimées.");
        return 0;
    }
}
