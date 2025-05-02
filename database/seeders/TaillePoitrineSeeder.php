<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaillePoitrine;

class TaillePoitrineSeeder extends Seeder
{
    public function run()
    {
        $taillesPoitrine = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        foreach ($taillesPoitrine as $taille) {
            TaillePoitrine::create(['name' => $taille]);
        }
    }
}
