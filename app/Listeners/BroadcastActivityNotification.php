<?php

namespace App\Listeners;

use App\Events\ActivityLogged;
use Illuminate\Contracts\Queue\ShouldQueue;

class BroadcastActivityNotification implements ShouldQueue
{
    public function handle(ActivityLogged $event)
    {
        // Broadcast pour les dashboards admin
        broadcast(new \App\Notifications\RealTimeActivity($event->activity));
    }
}