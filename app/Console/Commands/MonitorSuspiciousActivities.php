<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class MonitorSuspiciousActivities extends Command
{
    protected $signature = 'monitor:activities';
    
    public function handle()
    {
        $suspicious = ActivityLog::where('created_at', '>=', now()->subHour())
            ->whereIn('event', ['login_failed', 'permission_denied'])
            ->groupBy('causer_id')
            ->havingRaw('COUNT(*) > 5')
            ->get();
            
        $suspicious->each->notifyAdmins();
    }
}