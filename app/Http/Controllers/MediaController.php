<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    /**
     * Store a newly created media in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGallery(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media' => 'required|array',
            'media.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:102400',
            'is_public' => 'required|in:0,1,true,false',
            'quality' => 'sometimes|integer|min:1|max:100',
        ]);

        $isPublic = filter_var($request->is_public, FILTER_VALIDATE_BOOLEAN);
        $quality = $request->quality ?? 75;
        $user = auth()->user();
        $savedMedia = [];

        // dd($request->file('media'));

        foreach ($request->file('media') as $file) {
            try {
                // Traitement du média via le service
                $mediaData = $this->mediaService->processAndStoreMedia($file, $user->id, $quality);

                // Création de l'entrée en base de données
                $media = Gallery::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => $mediaData['type'],
                    'path' => $mediaData['path'],
                    'thumbnail_path' => $mediaData['thumbnail_path'],
                    'is_public' => $isPublic,
                ]);

                $savedMedia[] = $media;

            } catch (\Exception $e) {
                logger()->error('Erreur traitement média: ' . $e->getMessage());
                continue;
            }
        }

        if (empty($savedMedia)) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun média n\'a pu être traité.'
            ], 422);
        }

        return redirect()->route('profile.index')
            ->with('success', __('gallery_manage.upload_success'));
    }
}
