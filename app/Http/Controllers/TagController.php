<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.tags.index', [
            'tags' => Tag::withCount('articles')->latest()->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name'
        ], [
            'name.required' => __('tag.validation.name_required'),
            'name.string' => __('tag.validation.name_string'),
            'name.max' => __('tag.validation.name_max'),
            'name.unique' => __('tag.validation.name_unique'),
        ]);
        
        // Créer le tag avec un slug
        $tag = Tag::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);
        
        return response()->json([
            'tag' => $tag,
            'message' => __('tag.success.tag_created')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = Tag::find($id);
        
        if (!$tag) {
            return response()->json([
                'message' => __('tag.error.tag_not_found')
            ], 404);
        }
        
        return response()->json($tag);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id
        ], [
            'name.required' => __('tag.validation.name_required'),
            'name.string' => __('tag.validation.name_string'),
            'name.max' => __('tag.validation.name_max'),
            'name.unique' => __('tag.validation.name_unique'),
        ]);

        $tag = Tag::find($id);
        
        if (!$tag) {
            return response()->json([
                'message' => __('tag.error.tag_not_found')
            ], 404);
        }


        $tag->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name'])
        ]);

        return response()->json([
            'tag' => $tag,
            'message' => __('tag.success.tag_updated')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', __('tag.success.tag_deleted'));
    }
}
