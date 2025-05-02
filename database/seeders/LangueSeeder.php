<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Langue;

class LangueSeeder extends Seeder
{
    public function run()
    {
        $langues = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];

        foreach ($langues as $langue) {
            Langue::create(['name' => $langue]);
        }
    }
}
