<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
class GenreSeeder extends Seeder
{
    public function run()
    {
        $genres = ['Femme', 'Homme', 'Trans', 'Gay', 'Lesbienne', 'Bisexuelle', 'Queer'];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
