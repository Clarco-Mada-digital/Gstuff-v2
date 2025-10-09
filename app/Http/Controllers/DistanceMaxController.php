<?php

namespace App\Http\Controllers;
use App\Models\DistanceMax;

use Illuminate\Http\Request;

class DistanceMaxController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'distance_max' => 'required|integer',
        ], [
            'distance_max.required' => __('distance.distance_max.required'),
            'distance_max.integer' => __('distance.distance_max.integer'),
        ]);

        try {
            // Vérifie si une entrée existe, sinon la créer
            $distanceMax = DistanceMax::firstOrCreate([], ['distance_max' => $validated['distance_max']]);
            
            // Mise à jour
            $distanceMax->distance_max = $validated['distance_max'];
            $distanceMax->save();

            // Rediriger avec un message de succès
            return redirect()->back()->with('success', __('distance.updated'));
            
        } catch (\Exception $e) {
            \Log::error('Error updating maximum distance: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('distance.update_error'))
                ->withInput();
        }
    }
}
