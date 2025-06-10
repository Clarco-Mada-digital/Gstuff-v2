<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Importez la classe DB

class CantonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cantonsName = ['Vaud', 'Genève', 'Berne', 'Suise Alémanique', 'Jura', 'Fribourg'];
        $data = [];
        foreach ($cantonsName as $cantonName) {
            $data[] = [
                'nom' => $cantonName,
            ];
        }
        DB::table('cantons')->insert($data);
    }
}
