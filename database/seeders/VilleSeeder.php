<?php

namespace Database\Seeders;

use App\Models\Ville;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villes = [
            ['title' => 'Geneva'],
            ['title' => 'Lausanne'],
            ['title' => 'Bern'],
            ['title' => 'Zurich'],
            ['title' => 'Basel'],
            // Add more villes as needed
        ];

        foreach ($villes as $ville) {
            Ville::create($ville);
        }
    }
}
