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
            
            // Zip storage directory
            $storageZip = $backupDir . DIRECTORY_SEPARATOR . "storage_{$date}.zip";
            $storagePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public');
            
            $zip = new \ZipArchive();
            if ($zip->open($storageZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($storagePath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );
                
                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($storagePath) + 1);
                        $zip->addFile($filePath, $relativePath);
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
                ],
                'user_id' => Auth::id(),
            ]);
            
            $successMessage = "Sauvegarde terminée avec succès!\n";
            $successMessage .= "- Base de données: {$filename}\n";
            $successMessage .= "- Stockage: storage_{$date}.zip\n";
            $successMessage .= "Taille totale: " . $this->formatBytes(filesize($filepath) + filesize($storageZip));
            
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
            // Essayer de trouver un administrateur de différentes manières
            $admin = null;
            
            // Essayer différentes méthodes pour trouver un administrateur
            if (Schema::hasColumn('users', 'is_admin')) {
                $admin = User::where('is_admin', true)->first();
            } 
            
            if (!$admin && Schema::hasColumn('users', 'role')) {
                $admin = User::where('role', 'admin')->first();
            }
            
            // Si on n'a toujours pas trouvé d'admin, prendre le premier utilisateur
            if (!$admin) {
                $admin = User::first();
            }
            
            if ($admin && filter_var($admin->email, FILTER_VALIDATE_EMAIL)) {
                $admin->notify(new BackupNotification($status, $message, $details));
                $this->info('Notification envoyée à: ' . $admin->email);
            } else {
                $this->warn('Aucun administrateur avec email valide trouvé pour l\'envoi de notification');
                // Logger l'erreur
                \Log::warning('Impossible d\'envoyer la notification de sauvegarde: aucun administrateur avec email valide');
            }
        } catch (\Exception $e) {
            $this->error('Erreur lors de l\'envoi de la notification: ' . $e->getMessage());
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
