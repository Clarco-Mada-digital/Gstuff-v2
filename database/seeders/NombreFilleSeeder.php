<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NombreFille;

class NombreFilleSeeder extends Seeder
{
    public function run()
    {
        $nombreFilles = ['1 à 5', '5 à 15', 'plus de 15'];

        foreach ($nombreFilles as $nombre) {
            NombreFille::create(['name' => $nombre]);
        }
    }
}
