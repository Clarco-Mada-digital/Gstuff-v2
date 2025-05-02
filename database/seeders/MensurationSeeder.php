<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mensuration;

class MensurationSeeder extends Seeder
{
    public function run()
    {
        $mensurations = ['Mince', 'Normale', 'Pulpeuse', 'Ronde', 'Sportive'];

        foreach ($mensurations as $mensuration) {
            Mensuration::create(['name' => $mensuration]);
        }
    }
}
