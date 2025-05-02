<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pubis;

class PubisSeeder extends Seeder
{
    public function run()
    {
        $pubis = ['Entièrement rasé', 'Partiellement rasé', 'Tout naturel'];

        foreach ($pubis as $pubi) {
            Pubis::create(['name' => $pubi]);
        }
    }
}
