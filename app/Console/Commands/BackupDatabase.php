<?php

namespace App\Console\Commands;

use App\Notifications\BackupNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Backup;
use Illuminate\Support\Facades\Auth;
class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     * php artisan backup:run-custom
     * @var string
     */
    protected $signature = 'backup:run-custom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database and storage backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Démarrage du processus de sauvegarde...');
            
            // Vérifier si pg_dump est disponible
            $pgDumpCheck = shell_exec('pg_dump --version 2>&1');
            if (strpos($pgDumpCheck, 'pg_dump (PostgreSQL)') === false) {
                throw new \Exception(
                    "L'outil pg_dump n'est pas installé ou n'est pas dans le PATH.\n" .
                    "Veuillez installer les outils en ligne de commande de PostgreSQL.\n" .
                    "Téléchargez-les depuis : https://www.postgresql.org/download/windows/\n" .
                    "Assurez-vous d'ajouter le chemin des binaires (généralement C:\\Program Files\\PostgreSQL\\<version>\\bin) à votre variable d'environnement PATH."
                );
            }
            
            // Créer le répertoire de sauvegarde s'il n'existe pas
            $backupDir = storage_path('app/backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            // Generate filename with timestamp
            $date = Carbon::now()->format('Y-m-d_H-i-s');
            $filename = "backup_{$date}.sql";
            $filepath = $backupDir . DIRECTORY_SEPARATOR . $filename;
            
            // Database credentials
            $db = config('database.connections.pgsql');
            
            // Set PGPASSWORD environment variable
            putenv("PGPASSWORD=".$db['password']);
            
            // Dump database using pg_dump
            $command = sprintf(
                'pg_dump --username=%s --host=%s --port=%s --dbname=%s --file=%s --no-password',
                escapeshellarg($db['username']),
                escapeshellarg($db['host']),
                escapeshellarg($db['port']),
                escapeshellarg($db['database']),
                escapeshellarg($filepath)
            );
            
            exec($command, $output, $returnVar);

        
            
            if ($returnVar !== 0) {
                throw new \Exception('Échec du dump de la base de données: ' . implode("\n", $output));
            }

           
            // Zip storage directories
            $storageZip = $backupDir . DIRECTORY_SEPARATOR . "storage_{$date}.zip";

            $pathsToZip = [
                'public'  => storage_path('app' . DIRECTORY_SEPARATOR . 'public'),
                'backups' => storage_path('app' . DIRECTORY_SEPARATOR . 'backups'),
            ];

            $zip = new \ZipArchive();
            if ($zip->open($storageZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {

                foreach ($pathsToZip as $baseFolder => $path) {
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($path),
                        \RecursiveIteratorIterator::LEAVES_ONLY
                    );

                    foreach ($files as $file) {
                        if (!$file->isDir()) {
                            $filePath = $file->getRealPath();
                            // Stocker le chemin relatif à partir du nom de dossier de base ('public' ou 'backups')
                            $relativePath = $baseFolder . DIRECTORY_SEPARATOR . substr($filePath, strlen($path) + 1);
                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                }

                $zip->close();

            } else {
                throw new \Exception('Failed to create storage backup');
            }



            // Normaliser les chemins pour la base de données
            $normalizedDbPath = str_replace('\\', '/', $filepath);
            $normalizedStoragePath = str_replace('\\', '/', $storageZip);

            $backup = Backup::create([
                'name' => 'Backup ' . now()->format('d/m/Y H:i:s'),
                'type' => Backup::TYPE_FULL,
                'status' => Backup::STATUS_COMPLETED,
                'file_path_db' => dirname($normalizedDbPath) . '/' . basename($normalizedDbPath),
                'file_name_db' => basename($normalizedDbPath),
                'file_path_storage' => dirname($normalizedStoragePath) . '/' . basename($normalizedStoragePath),
                'file_name_storage' => basename($normalizedStoragePath),
                'size_db' => filesize($filepath),
                'size_storage' => filesize($storageZip),
                'disk' => 'local',
                'metadata' => [
                    'started_at' => now(),
                    'source' => Auth::id() ? 'user' : 'system',
                    'is_uploaded' => false,
                ],
                'user_id' => Auth::id(),
            ]);


           // Supprimer les sauvegardes locales (is_uploaded = false) plus anciennes que les 5 plus récentes
            $recentBackups = Backup::where('metadata->is_uploaded', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('id')
            ->toArray();

            $oldBackups = Backup::where('metadata->is_uploaded', false)
            ->whereNotIn('id', $recentBackups)
            ->get();

            foreach ($oldBackups as $old) {
            // Supprimer les fichiers physiques
            if ($old->file_path_db && file_exists($old->file_path_db)) {
                unlink($old->file_path_db);
            }
            if ($old->file_path_storage && file_exists($old->file_path_storage)) {
                unlink($old->file_path_storage);
            }

            // Supprimer l'entrée en base
            $old->delete();
            }

            
           // Copier les fichiers dans le disque public pour les rendre accessibles via URL
            Storage::disk('public')->put("backups/{$filename}", file_get_contents($filepath));
            Storage::disk('public')->put("backups/storage_{$date}.zip", file_get_contents($storageZip));

            // Générer les liens de téléchargement
            $downloadLinkDb = asset("storage/backups/{$filename}");
            $downloadLinkStorage = asset("storage/backups/storage_{$date}.zip");

            // Message enrichi avec les liens
            $successMessage = "✅ Sauvegarde terminée avec succès!\n";
            $successMessage .= "- Base de données: {$filename}\n";
            $successMessage .= "- Stockage: storage_{$date}.zip\n";
            $successMessage .= "📦 Taille totale: " . $this->formatBytes(filesize($filepath) + filesize($storageZip)) . "\n\n";
            $successMessage .= "🔗 Liens de téléchargement:\n";
            $successMessage .= "- [Télécharger la base de données]({$downloadLinkDb})\n";
            $successMessage .= "- [Télécharger le stockage]({$downloadLinkStorage})\n";
            
            $this->info($successMessage);
            
            // Envoyer une notification de succès
            $this->notifyAdmin('success', 'Sauvegarde complétée avec succès', $successMessage);
            
        } catch (\Exception $e) {
            $errorMessage = 'Échec de la sauvegarde: ' . $e->getMessage();
            $this->error($errorMessage);
            
            // Envoyer une notification d'échec
            $this->notifyAdmin('error', 'Échec de la sauvegarde', $errorMessage);
            
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Envoyer une notification à l'administrateur
     */
    protected function notifyAdmin($status, $message, $details = null)
    {
        try {
            // Récupérer tous les administrateurs avec un email valide
            $admins = User::where('profile_type', 'admin')
                ->whereNotNull('email')
                ->get()
                ->filter(function ($admin) {
                    return filter_var($admin->email, FILTER_VALIDATE_EMAIL);
                });
    
            if ($admins->isEmpty()) {
                $this->warn('Aucun administrateur avec email valide trouvé pour l\'envoi de notification');
                \Log::warning('Impossible d\'envoyer la notification de sauvegarde: aucun administrateur avec email valide');
                return;
            }
            if($status === 'success'){
            foreach ($admins as $admin) {
                $admin->notify(new BackupNotification($status, $message, $details));
                $this->info('Notification envoyée à: ' . $admin->email);
            }
            }
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
            \Log::error('Erreur notification admin: ' . $e->getMessage());
        }
    }
    
    
    /**
     * Formater la taille en octets en format lisible
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
