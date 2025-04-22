<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileVisibilityController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'visibility' => 'required|in:public,private,custom',
            'countries' => 'required_if:visibility,custom|array',
            'countries.*' => 'string|size:2',
        ]);

        $user = auth()->user();
        $user->visibility = $validated['visibility'];
        
        if ($validated['visibility'] === 'custom') {
            $user->visible_countries = $validated['countries'];
        } else {
            $user->visible_countries = null;
        }

        $user->save();

        return back()->with('success', 'Paramètres de visibilité mis à jour');
    }

    public function show()
    {
        $user = auth()->user();
        return view('profile.visibility', compact('user'));
    }

    public function destroy()
    {
        $user = auth()->user();
        $user->visibility = 'public';
        $user->visible_countries = null;
        $user->save();

        return back()->with('success', 'Paramètres de visibilité réinitialisés');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('auth.visibility', compact('user'));
    }
}
