<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mobilite;

class MobiliteSeeder extends Seeder
{
    public function run()
    {
        $mobilites = ['Je reçois', 'Je me déplace'];

        foreach ($mobilites as $mobilite) {
            Mobilite::create(['name' => $mobilite]);
        }
    }
}
