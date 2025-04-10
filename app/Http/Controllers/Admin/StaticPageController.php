<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = StaticPage::all();
        return view('admin.static-pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.static-pages.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|alpha_dash|unique:static_pages,slug',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);
    
        StaticPage::create([
            'slug' => $validated['slug'],
            'title' => $validated['title'],
            'content' => $validated['content'], // Ajout du contenu
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description']
        ]);
    
        return redirect()->route('static.index')
            ->with('success', 'Page créée avec succès');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staticPage = StaticPage::findOrFail($id);
        return view('admin.static-pages.edit', compact('staticPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaticPage $staticPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $staticPage->update($validated);
        

        return redirect()->route('static.index')
            ->with('success', 'Page mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
