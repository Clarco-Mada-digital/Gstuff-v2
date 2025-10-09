<?php

namespace App\Console;

use App\Models\ActivityLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('model:prune', [
            '--model' => [ActivityLog::class],
        ])->daily();

        // Suppression des stories expirées toutes les 5 minutes
        $schedule->command('stories:delete-expired')
                ->hourly()
                ->appendOutputTo(storage_path('logs/story-cleanup.log'));
                 
        $schedule->command('stories:clean')->everyMinute();

        // Sauvegarde quotidienne à minuit
        $schedule->command('backup:run-custom')
                 ->dailyAt('00:00')
                 ->onSuccess(function () {
                     // Log du succès
                     \Log::info('Sauvegarde automatique terminée avec succès');
                 })
                 ->onFailure(function () {
                     // Log de l'échec
                     \Log::error('Échec de la sauvegarde automatique');
                 });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
