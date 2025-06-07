<?php

namespace App\Console\Commands;

use App\Models\Story;
use Illuminate\Console\Command;

class CleanExpiredStories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-expired-stories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Story::where('expires_at', '<', now())->delete();
        $this->info('Expired stories cleaned!');
    }
}
