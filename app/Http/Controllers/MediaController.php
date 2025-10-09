<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\User;
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

        $galleryImageCount = Gallery::where('user_id', $user->id)->where('type', 'image')->count();
        $galleryVideoCount = Gallery::where('user_id', $user->id)->where('type', 'video')->count();

        if ($isPublic && $galleryImageCount >= 10) {
            return redirect()->route('profile.index')->with('error', __('gallery_manage.quota_exceededImage'));
        }

        if ($isPublic && $galleryVideoCount >= 10) {
            return redirect()->route('profile.index')->with('error', __('gallery_manage.quota_exceededVideo'));
        }

        $remainingImageSlots = 10 - $galleryImageCount;
        $remainingVideoSlots = 10 - $galleryVideoCount;

        $mediaFiles = $request->file('media');
        $mediaFilesCount = count($mediaFiles);
        $mediaFilesImages = [];
        $mediaFilesVideos = [];

        foreach ($mediaFiles as $file) {
            $mimeType = $file->getMimeType();
            if (strpos($mimeType, 'video/') === 0) {
                $mediaFilesVideos[] = $file;
            } else {
                $mediaFilesImages[] = $file;
            }
        }

        $mediaFilesImages = array_slice($mediaFilesImages, 0, $remainingImageSlots);
        $mediaFilesVideos = array_slice($mediaFilesVideos, 0, $remainingVideoSlots);

       
       


        foreach ($mediaFilesImages as $file) {
            try {
                // Traitement du média via le service
                $mediaData = $this->mediaService->processAndStoreMedia($file, $user->id, $quality);
                $thumbnailPath = $this->mediaService->generateThumbnail($file, $user->id);

                // Création de l'entrée en base de données
                $media = Gallery::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => $mediaData['type'],
                    'path' => $mediaData['path'],
                    'thumbnail_path' => $thumbnailPath,
                    'is_public' => $isPublic,
                ]);

                $savedMedia[] = $media;
                $user->update(['rate_activity' => $user->rate_activity + 1]);
                $user->update(['last_activity' => now()]);

            } catch (\Exception $e) {
                logger()->error('Erreur traitement média: ' . $e->getMessage());
                continue;
            }
        }

        foreach ($mediaFilesVideos as $file) {
            try {
                // Traitement du média via le service
                $mediaData = $this->mediaService->processAndStoreMedia($file, $user->id, $quality);
                $thumbnailPath = $this->mediaService->generateThumbnail($file, $user->id);

                // Création de l'entrée en base de données
                $media = Gallery::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => $mediaData['type'],
                    'path' => $mediaData['path'],
                    'thumbnail_path' => $thumbnailPath,
                    'is_public' => $isPublic,
                ]);

                $savedMedia[] = $media;
                $user->update(['rate_activity' => $user->rate_activity + 1]);
                $user->update(['last_activity' => now()]);

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


    // protected function generateThumbnail($file, $user)
    // {
       
        
    //     try {
           

    //         $manager = new ImageManager(new Driver());

    //         // Créer le répertoire des miniatures s'il n'existe pas
    //         $thumbnailsDir = "galleries/{$user->id}/thumbnails";

    //         if (!Storage::disk('public')->exists($thumbnailsDir)) {
    //             $result = Storage::disk('public')->makeDirectory($thumbnailsDir, 0755, true);
    //         }

         
    //         $image = $manager->read($file->getRealPath());

    //         $image->resize(400, 400, function ($constraint) {
    //             $constraint->aspectRatio();
    //             $constraint->upsize();
    //         });
            
            
    //         $path = "{$thumbnailsDir}/" . uniqid() . '.jpg';
    //         $encoded = $image->toJpeg(90); 
    //         $result = Storage::disk('public')->put($path, $encoded);
            
    //         if ($result) {
    //             return $path;
    //         } else {
    //             return null;
    //         }
            
    //     } catch (\Exception $e) {
    //         $errorMessage = 'Erreur lors de la génération de la miniature : ' . $e->getMessage();
    //         logger()->error($errorMessage, [
    //             'exception' => get_class($e),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return null;
    //     } 
    // }


    /**
     * Remove the specified media from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Retrieve the media item by its ID
        $media = Gallery::findOrFail($id);

        // Check if the authenticated user owns the media item
        if (Auth::id() !== $media->user_id) {
            return redirect()->route('profile.index')->with('error', 'Unauthorized action.');
        }

        try {
            // Delete the media file and thumbnail from storage
            Storage::delete($media->path);
            if ($media->thumbnail_path) {
                Storage::delete($media->thumbnail_path);
            }

            // Delete the media item from the database
            $media->delete();
            $user = User::find($media->user_id);
            $user->update(['rate_activity' => $user->rate_activity - 1]);
            $user->update(['last_activity' => now()]);

            return redirect()->route('profile.index')->with('success', __('gallery_manage.delete_success'));
        } catch (\Exception $e) {
            logger()->error('Error deleting media: ' . $e->getMessage());

            return redirect()->route('profile.index')->with('error', __('gallery_manage.delete_error'));
        }
    }
}
