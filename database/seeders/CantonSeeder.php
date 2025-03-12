<?php

namespace Database\Seeders;

use App\Models\Canton;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CantonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cantons = [
            ['title' => 'Zurich'],
            ['title' => 'Berne'],
            ['title' => 'Lucerne'],
            ['title' => 'Uri'],
            ['title' => 'Schwytz'],
            ['title' => 'Obwald'],
            ['title' => 'Nidwald'],
            ['title' => 'Glaris'],
            ['title' => 'Zoug'],
            ['title' => 'Fribourg'],
            ['title' => 'Soleure'],
            ['title' => 'Bâle-Ville'],
            ['title' => 'Bâle-Campagne'],
            ['title' => 'Schaffhouse'],
            ['title' => 'Appenzell Rhodes-Extérieures'],
            ['title' => 'Appenzell Rhodes-Intérieures'],
            ['title' => 'Saint-Gall'],
            ['title' => 'Grisons'],
            ['title' => 'Argovie'],
            ['title' => 'Thurgovie'],
            ['title' => 'Tessin'],
            ['title' => 'Vaud'],
            ['title' => 'Valais'],
            ['title' => 'Neuchâtel'],
            ['title' => 'Genève'],
            ['title' => 'Jura'],
        ];

        foreach ($cantons as $canton) {
            Canton::create($canton);
        }
    }
}
