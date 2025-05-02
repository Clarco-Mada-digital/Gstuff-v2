<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CouleurCheveux;
class CouleurCheveuxSeeder extends Seeder
{
    public function run()
    {
        $couleursCheveux = ['Blonds', 'Brune', 'Châtin', 'Gris', 'Noiraude', 'Rousse', 'Autre'];

        foreach ($couleursCheveux as $couleur) {
            CouleurCheveux::create(['name' => $couleur]);
        }
    }
}
