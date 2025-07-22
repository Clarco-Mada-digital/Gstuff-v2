<?php

namespace App\Services;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class MediaService
{
    protected $imageManager;
    protected $ffmpegConfig;

    /**
     * Initialise le service de gestion des médias avec la configuration appropriée.
     * 
     * Configuration requise :
     * 
     * 1. Pour Windows :
     *    - Télécharger FFmpeg depuis https://ffmpeg.org/download.html
     *    - Extraire le contenu dans C:\\ffmpeg
     *    - Ajouter C:\\ffmpeg\\bin aux variables d'environnement PATH
     *    - Redémarrer l'ordinateur ou la session utilisateur
     *    - Vérifier l'installation avec `ffmpeg -version` dans CMD
     *
     * 2. Pour Linux (Ubuntu/Debian) :
     *    ```bash
     *    # Mettre à jour les paquets
     *    sudo apt update
     *    
     *    # Installer FFmpeg et les dépendances
     *    sudo apt install -y ffmpeg \
     *        php-gd \
     *        php-zip \
     *        libavcodec-extra \
     *        libavformat-dev \
     *        libx264-dev
     *    
     *    # Installer PHP-FFMpeg via Composer
     *    composer require php-ffmpeg/php-ffmpeg
     *    
     *    # Vérifier l'installation
     *    which ffmpeg     # Doit retourner /usr/bin/ffmpeg
     *    which ffprobe    # Doit retourner /usr/bin/ffprobe
     *    ```
     *
     * 3. Vérification de l'environnement :
     *    - PHP 8.0 ou supérieur requis
     *    - Extension GD activée (php.ini: extension=gd)
     *    - Suffisamment d'espace disque pour le traitement des fichiers temporaires
     *    - Permissions d'écriture sur les dossiers de stockage
     *
     * @throws \RuntimeException Si FFmpeg n'est pas installé ou accessible
     */
    public function __construct()
    {
        // Initialisation du gestionnaire d'images avec le driver GD
        $this->imageManager = new ImageManager(Driver::class);
        
        // Détection du système d'exploitation
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        
        // Configuration des chemins FFmpeg selon l'OS
        $this->ffmpegConfig = [
            'ffmpeg.binaries'  => $isWindows 
                ? 'C:\\ffmpeg\\bin\\ffmpeg.exe' 
                : '/usr/bin/ffmpeg',
                
            'ffprobe.binaries' => $isWindows
                ? 'C:\\ffmpeg\\bin\\ffprobe.exe'
                : '/usr/bin/ffprobe',
                
            'timeout'          => 3600,  // 1 heure de timeout
            'ffmpeg.threads'   => 0,     // 0 = utiliser tous les cœurs disponibles
        ];
        
        // Vérification de l'installation de FFmpeg
        $this->checkFFmpegInstallation();
    }
    
    /**
     * Vérifie que FFmpeg est correctement installé et accessible
     * 
     * @throws \RuntimeException Si FFmpeg n'est pas installé ou accessible
     */
    protected function checkFFmpegInstallation(): void
    {
        $ffmpegPath = $this->ffmpegConfig['ffmpeg.binaries'];
        $ffprobePath = $this->ffmpegConfig['ffprobe.binaries'];
        
        if (!file_exists($ffmpegPath) || !is_executable($ffmpegPath)) {
            throw new \RuntimeException(
                "FFmpeg n'est pas installé ou n'est pas accessible à l'emplacement : " . $ffmpegPath . "\n" .
                "Veuillez installer FFmpeg et configurer les chemins correctement."
            );
        }
        
        if (!file_exists($ffprobePath) || !is_executable($ffprobePath)) {
            throw new \RuntimeException(
                "FFprobe n'est pas installé ou n'est pas accessible à l'emplacement : " . $ffprobePath . "\n" .
                "FFprobe est nécessaire pour l'analyse des métadonnées des vidéos."
            );
        }
    }

    /**
     * Traite et enregistre un média (image ou vidéo)
     */
    public function processAndStoreMedia(UploadedFile $file, int $userId, int $quality = 75): array
    {
        $mimeType = $file->getMimeType();
        $isImage = str_starts_with($mimeType, 'image/');
        
        if ($isImage) {
            $path = $this->compressAndStoreImage($file, $userId, $quality);
            $thumbnailPath = $this->generateThumbnail($file, $userId);
        } else {
            $path = $this->compressAndStoreVideo($file, $userId);
            $thumbnailPath = null;
        }

        return [
            'path' => $path,
            'thumbnail_path' => $thumbnailPath,
            'type' => $isImage ? 'image' : 'video',
            'mime_type' => $mimeType,
        ];
    }

    /**
     * Compresse et enregistre une image
     */
    public function compressAndStoreImage(UploadedFile $file, int $userId, int $quality = 75): string
    {
        $directory = "galleries/{$userId}";
        $this->ensureDirectoryExists($directory);

        $filename = uniqid() . '.jpg';
        $path = "{$directory}/{$filename}";
        
        $image = $this->imageManager->read($file->getRealPath());
        $image->scaleDown(1920);
        $encodedImage = (string) $image->toJpeg($quality);
        
        Storage::disk('public')->put($path, $encodedImage);
        
        return $path;
    }

    /**
     * Compresse et enregistre une vidéo
     */
    // public function compressAndStoreVideo(UploadedFile $file, int $userId): string
    // {
    //     $directory = "galleries/{$userId}";
    //     $this->ensureDirectoryExists($directory);

    //     $filename = uniqid() . '.mp4';
    //     $path = "{$directory}/{$filename}";
    //     $fullPath = Storage::disk('public')->path($path);
        
    //     $ffmpeg = FFMpeg::create($this->ffmpegConfig);
    //     $video = $ffmpeg->open($file->getRealPath());
        
    //     $format = new X264();
    //     $format->setAudioCodec('aac');
    //     $format->setKiloBitrate(1000);
    //     $format->setAudioKiloBitrate(128);
        
    //     $video->save($format, $fullPath);
        
    //     return $path;
    // }

    // public function compressAndStoreVideo(UploadedFile $file, int $userId): string
    // {
    //     $directory = "galleries/{$userId}";
    //     $this->ensureDirectoryExists($directory);
    //     $filename = uniqid() . '.mp4';
    //     $path = "{$directory}/{$filename}";
    //     $fullPath = Storage::disk('public')->path($path);

    //     $ffmpeg = FFMpeg::create($this->ffmpegConfig);
    //     $video = $ffmpeg->open($file->getRealPath());

    //     $format = new X264('aac', 'libx264');
    //     $format->setKiloBitrate(1000);
    //     $format->setAudioKiloBitrate(128);

    //     // Redimensionner la vidéo à une résolution plus basse
    //     $video->filters()->resize(new \FFMpeg\Coordinate\Dimension(1280, 720));

    //     $video->save($format, $fullPath);

    //     return $path;
    // }

    public function compressAndStoreVideo(UploadedFile $file, int $userId): string
    {
        $directory = "galleries/{$userId}";
        $this->ensureDirectoryExists($directory);
        $filename = uniqid() . '.mp4';
        $path = "{$directory}/{$filename}";
        $fullPath = Storage::disk('public')->path($path);
        
        // Vérifier la taille du fichier original
        $originalSize = $file->getSize();
        
        // Si le fichier est déjà petit, on le sauvegarde directement
        if ($originalSize < 2 * 1024 * 1024) { // Moins de 2MB
            Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
            return $path;
        }

        $ffmpeg = FFMpeg::create($this->ffmpegConfig);
        $video = $ffmpeg->open($file->getRealPath());

        // Obtenir les dimensions originales de la vidéo
        $dimensions = $video->getStreams()->videos()->first()->getDimensions();
        $width = $dimensions->getWidth();
        $height = $dimensions->getHeight();
        
        // Calculer les nouvelles dimensions en conservant le ratio
        $maxWidth = 1280;
        $maxHeight = 720;
        
        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = (int)($width * $ratio);
            $newHeight = (int)($height * $ratio);
            
            // S'assurer que les dimensions sont paires (requis pour certains codecs)
            $newWidth = $newWidth % 2 === 0 ? $newWidth : $newWidth - 1;
            $newHeight = $newHeight % 2 === 0 ? $newHeight : $newHeight - 1;
            
            $video->filters()->resize(new \FFMpeg\Coordinate\Dimension($newWidth, $newHeight));
        }

        // Configuration de compression agressive
        $format = new X264('aac');
        $format->setKiloBitrate(600);  // Débit vidéo en kbps
        $format->setAudioKiloBitrate(64);  // Débit audio en kbps
        
        // Paramètres avancés pour une meilleure compression
        $format->setAdditionalParameters([
            '-preset', 'slow',          // Meilleure compression
            '-crf', '28',               // Augmente la compression (18-28 est un bon compromis)
            '-movflags', '+faststart',  // Pour le streaming web
            '-pix_fmt', 'yuv420p',      // Meilleure compatibilité
            '-threads', '0'             // Utiliser tous les cœurs CPU disponibles
        ]);

        // Sauvegarder la vidéo compressée
        $video->save($format, $fullPath);
        
        // Vérifier la taille du fichier compressé
        $compressedSize = filesize($fullPath);
        
        // Si la compression n'a pas réduit la taille, garder l'original
        if ($compressedSize >= $originalSize) {
            Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
        }

        return $path;
    }



    /**
     * Génère une miniature pour une image
     */
    public function generateThumbnail(UploadedFile $file, int $userId): ?string
    {
        try {
            $thumbnailDir = "galleries/{$userId}/thumbnails";
            $this->ensureDirectoryExists($thumbnailDir);

            $filename = uniqid() . '.jpg';
            $path = "{$thumbnailDir}/{$filename}";
            
            $image = $this->imageManager->read($file->getRealPath())
                ->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toJpeg($quality);
            
            $encodedThumbnail = (string) $image;
            Storage::disk('public')->put($path, $encodedThumbnail);
            
            return $path;
            
        } catch (\Exception $e) {
            logger()->error('Erreur génération miniature: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Vérifie et crée un répertoire s'il n'existe pas
     */
    protected function ensureDirectoryExists(string $directory): void
    {
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory, 0755, true);
        }
    }
}
