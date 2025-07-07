<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class StoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400' // 100MB max
        ]);

        $file = $request->file('media');
        $mediaType = Str::contains($file->getMimeType(), 'video') ? 'video' : 'image';
        
        $path = $file->store('stories', 'public');

        $story = Story::create([
            'user_id' => auth()->id(),
            'media_path' => $path,
            'media_type' => $mediaType
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Story created successfully',
                'data' => [
                    'id' => $story->id,
                    'media_url' => Storage::url($path),
                    'media_type' => $mediaType,
                    'created_at' => $story->created_at->toDateTimeString()
                ]
            ], 201);
        }

        return redirect()->back()->with('success', 'Votre story a été publiée avec succès !');
    }
}
