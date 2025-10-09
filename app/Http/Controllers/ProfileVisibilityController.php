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
        ], [
            'visibility.required' => __('visibility.validation.visibility_required'),
            'visibility.in' => __('visibility.validation.visibility_in'),
            'countries.required_if' => __('visibility.validation.countries_required_if'),
            'countries.array' => __('visibility.validation.countries_array'),
            'countries.*.string' => __('visibility.validation.countries_*_string'),
            'countries.*.size' => __('visibility.validation.countries_*_size'),
        ]);

        $user = auth()->user();
        $user->visibility = $validated['visibility'];
        
        if ($validated['visibility'] === 'custom') {
            $user->visible_countries = $validated['countries'];
        } else {
            $user->visible_countries = null;
        }

        $user->save();

        return back()->with('success', __('visibility.success.visibility_updated'));
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

        return back()->with('success', __('visibility.success.visibility_reset'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('auth.visibility', compact('user'));
    }
}
