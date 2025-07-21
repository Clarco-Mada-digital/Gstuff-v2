<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class MediaController extends Controller
{
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
            'media.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:102400', // 100MB max
            'is_public' => 'required|in:0,1,true,false',
        ]);

        // Convert is_public to boolean
        $isPublic = filter_var($request->is_public, FILTER_VALIDATE_BOOLEAN);

        $user = auth()->user();
        $savedMedia = [];

        foreach ($request->file('media') as $file) {
            try {
                // Validate file
                if (!$file->isValid()) {
                    throw new \InvalidArgumentException('Invalid or corrupted file.');
                }

                // Store the file
                $path = $file->store("galleries/{$user->id}", 'public');
                
                // Generate thumbnail if it's an image
                $thumbnailPath = null;
                if (str_starts_with($file->getMimeType(), 'image/')) {
                    $thumbnailPath = $this->generateThumbnail($file, $user->id);
                }


                // Create gallery entry
                $media = Gallery::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'type' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video',
                    'path' => $path,
                    'thumbnail_path' => $thumbnailPath,
                    'is_public' => $isPublic,
                ]);

                $savedMedia[] = $media;

            } catch (\Exception $e) {
                // Log the error and continue with next file
                logger()->error('Error saving media: ' . $e->getMessage());
                continue;
            }
        }

        if (empty($savedMedia)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save any media files.'
            ], 422);
        }

        return redirect()->route('profile.index')
        ->with('success', __('gallery_manage.upload_success'));
    }

    /**
     * Generate a thumbnail for the given image file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  int  $userId
     * @return string|null
     */
    protected function generateThumbnail($file, $userId)
    {
        try {
            $manager = new ImageManager(new Driver());

            // Créer le répertoire des miniatures s'il n'existe pas
            $thumbnailDir = "galleries/{$userId}/thumbnails";
            if (!Storage::disk('public')->exists($thumbnailDir)) {
                Storage::disk('public')->makeDirectory($thumbnailDir, 0755, true);
            }

            // Lire et traiter l'image
            $image = $manager->read($file->getRealPath())
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encodeByMediaType('image/jpg');
            
            // Générer un nom de fichier unique
            $filename = uniqid() . '.jpg';
            $path = "{$thumbnailDir}/{$filename}";
            
            // Sauvegarder la miniature
            $saved = Storage::disk('public')->put($path, (string)$image);
            
            if (!$saved) {
                throw new \RuntimeException('Impossible de sauvegarder la miniature');
            }
            
            // Vérifier que le fichier a bien été créé
            if (!Storage::disk('public')->exists($path)) {
                throw new \RuntimeException('La miniature n\'a pas été créée correctement');
            }
            
            return $path;
            
        } catch (\Exception $e) {
            logger()->error('Error generating thumbnail: ' . $e->getMessage());
            logger()->error($e->getTraceAsString());
            return null;
        }
    }
}
