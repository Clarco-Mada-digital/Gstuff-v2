<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Silhouette;

class SilhouetteSeeder extends Seeder
{
    public function run()
    {
        $silhouettes = ['Fine', 'Mince', 'Normale', 'Sportive', 'Pulpeuse', 'Ronde'];

        foreach ($silhouettes as $silhouette) {
            Silhouette::create(['name' => $silhouette]);
        }
    }
}
