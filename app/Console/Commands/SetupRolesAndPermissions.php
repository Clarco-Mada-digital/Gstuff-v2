<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-roles-and-permissions';

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
        $this->callSilent('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
        $this->info('Rôles et permissions initialisés avec succès');
    }
}
