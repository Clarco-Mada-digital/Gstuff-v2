<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Services\MediaService;

class StoryController extends Controller
{

    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400' // 100MB max
        ]);

        $file = $request->file('media');
        $mediaType = Str::contains($file->getMimeType(), 'video') ? 'video' : 'image';
        
        $mediaData = $this->mediaService->processAndStoreMedia($file, auth()->id(), 75, 'story');
        $path = $mediaData['path'];

        $story = Story::create([
            'user_id' => auth()->id(),
            'media_path' => $path,
            'media_type' => $mediaType
        ]);

        $user = User::find(auth()->id());
        $user->update(['rate_activity' => $user->rate_activity + 1]);
        $user->update(['last_activity' => now()]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('storie_media_viewer.story_created'),
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


    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();
        return response()->json([
            'success' => true,
            'message' => __('storie_media_viewer.story_deleted'),
            'data' => [
                'id' => $story->id,
                'media_url' => Storage::url($story->media_path),
                'media_type' => $story->media_type,
                'created_at' => $story->created_at->toDateTimeString()
            ]
        ], 200);
    }

    public function updateStatus($id)
    {
        $story = Story::findOrFail($id);
        $story->expires_at = now()->addDays(1);
        $story->save();
        
        return response()->json([
            'success' => true,
            'message' => __('storie_media_viewer.story_republished'),
            'story' => $story->fresh()
        ]);
    }
}
