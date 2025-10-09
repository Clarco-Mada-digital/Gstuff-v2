<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)	
    {
        if ($request->has('json')) {
            return response()->json([
                'categories' => ArticleCategory::withCount('articles')->get(),
                'tags' => Tag::withCount('articles')->get()
            ]);
        }

        return view('admin.taxonomy.index', [
            'categories' => ArticleCategory::withCount('articles')->get(),
            'tags' => Tag::withCount('articles')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string'
        ], [
            'name.required' => __('article_category.name.required'),
            'name.max' => __('article_category.name.max', ['max' => 255]),
            'name.unique' => __('article_category.name.unique'),
            'description.string' => __('article_category.description.string'),
        ]);

        ArticleCategory::create([
            ...$validated,
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', __('article_category.stored'));
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
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string'
        ], [
            'name.required' => __('article_category.name.required'),
            'name.max' => __('article_category.name.max', ['max' => 255]),
            'name.unique' => __('article_category.name.unique'),
            'description.string' => __('article_category.description.string'),
        ]);

        $category->update([
            ...$validated,
            'slug' => Str::slug($validated['name']),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', __('article_category.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleCategory $category)
    {
        try {
            $category->delete();
            return back()->with('success', __('article_category.deleted'));
        } catch (\Exception $e) {
            return back()->with('error', __('article_category.delete_error'));
        }
    }
}
