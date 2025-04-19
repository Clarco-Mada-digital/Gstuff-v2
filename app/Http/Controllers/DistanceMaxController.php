<?php

namespace App\Http\Controllers;
use App\Models\DistanceMax;

use Illuminate\Http\Request;

class DistanceMaxController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'distance_max' => 'required|integer',
        ]);

        // Vérifie si une entrée existe, sinon la créer
        $distanceMax = DistanceMax::firstOrCreate([], ['distance_max' => $request->distance_max]);
        
        // Mise à jour
        $distanceMax->distance_max = $request->distance_max;
        $distanceMax->save();

       // Rediriger avec un message de succès
          return redirect()->back()->with('success', 'Distance mise à jour avec succès.');
    }
}
