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
