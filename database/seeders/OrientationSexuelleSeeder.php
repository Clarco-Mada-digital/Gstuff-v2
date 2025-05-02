<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrientationSexuelle;

class OrientationSexuelleSeeder extends Seeder
{
    public function run()
    {
        $oriantationSexuelles = ['Bisexuelle', 'Hétéro', 'Lesbienne', 'Polyamoureux', 'Polyamoureuse', 'Autre'];

        foreach ($oriantationSexuelles as $orientation) {
            OrientationSexuelle::create(['name' => $orientation]);
        }
    }
}
