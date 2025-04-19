<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistanceMaxSeeder extends Seeder
{
    public function run()
    {
        // Insérer une entrée par défaut dans la table distance_max
        DB::table('distance_max')->insert([
            'distance_max' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
