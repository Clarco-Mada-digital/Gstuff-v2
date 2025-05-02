<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PratiqueSexuelle;

class PratiqueSexuelleSeeder extends Seeder
{
    public function run()
    {
        $pratiquesSexuelles = ['69', 'Cunnilingus', 'Ejaculation corps', 'Ejaculation facial', 'Face-sitting', 'Fellation', 'Fétichisme', 'GFE', 'Gorge Profonde', 'Lingerie', 'Massage érotique', 'Rapport sexuel', 'Blow job', 'Hand job'];

        foreach ($pratiquesSexuelles as $pratique) {
            PratiqueSexuelle::create(['name' => $pratique]);
        }
    }
}
