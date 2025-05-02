<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paiement;

class PaiementSeeder extends Seeder
{
    public function run()
    {
        $paiements = ['CHF', 'Euros', 'Dollars', 'Twint', 'Visa', 'Mastercard', 'American Express', 'Maestro', 'Postfinance', 'Bitcoin'];

        foreach ($paiements as $paiement) {
            Paiement::create(['name' => $paiement]);
        }
    }
}
