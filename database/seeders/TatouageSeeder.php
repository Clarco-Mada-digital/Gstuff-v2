<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tatouage;

class TatouageSeeder extends Seeder
{
    public function run()
    {
        $tatouages = ['Avec tattos', 'Sans tatto'];

        foreach ($tatouages as $tatou) {
            Tatouage::create(['name' => $tatou]);
        }
    }
}
