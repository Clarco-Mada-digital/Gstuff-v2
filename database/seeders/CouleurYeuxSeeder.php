<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CouleurYeux;

class CouleurYeuxSeeder extends Seeder
{
    public function run()
    {
        $couleursYeux = ['Bleus', 'Bruns', 'Bruns clairs', 'Gris', 'Jaunes', 'Marrons', 'Noirs', 'Verts', 'Autre'];

        foreach ($couleursYeux as $couleur) {
            CouleurYeux::create(['name' => $couleur]);
        }
    }
}
