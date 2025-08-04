<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\BackupDestination\Backup as BackupFile;
use Spatie\Backup\Helpers\Format;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use App\Models\Backup;
class BackupController extends Controller
{
    public function index()
    {
        $backupsFiles = Backup::all();
        

        return view('admin.backups.index', compact('backupsFiles'));
    }

    public function create()
    {
        try {
            Artisan::call('backup:run-custom');
            
            return back()->with('success', 'Sauvegarde supprimée avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            
            // Vérifier si les fichiers existent
            if (!file_exists($backup->file_path_db) || !file_exists($backup->file_path_storage)) {
                return back()->with('error', 'Un ou plusieurs fichiers de sauvegarde sont introuvables.');
            }
            
            // Créer un nom d'archive unique
            $zipFileName = 'backup_' . $backup->created_at->format('Y-m-d_His') . '.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);
            
            // Créer le répertoire temp s'il n'existe pas
            if (!file_exists(dirname($zipPath))) {
                mkdir(dirname($zipPath), 0755, true);
            }
            
            // Créer une nouvelle archive ZIP
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                // Ajouter le fichier de base de données
                $zip->addFile($backup->file_path_db, basename($backup->file_path_db));
                
                // Ajouter le fichier de stockage
                $zip->addFile($backup->file_path_storage, basename($backup->file_path_storage));
                
                $zip->close();
                
                // Télécharger l'archive
                return response()->download($zipPath)->deleteFileAfterSend(true);
            }
            
            return back()->with('error', 'Impossible de créer l\'archive de sauvegarde.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du téléchargement : ' . $e->getMessage());
        }
    }

    // public function restore($id)
    // {
    //     try {
    //         $backup = Backup::findOrFail($id);
            
    //         // Vérifier si les fichiers existent
    //         if (!file_exists($backup->file_path_db) || !file_exists($backup->file_path_storage)) {
    //             return back()->with('error', 'Un ou plusieurs fichiers de sauvegarde sont introuvables.');
    //         }
            
    //         // 1. Restauration de la base de données PostgreSQL
    //         $dbConfig = config('database.connections.pgsql');
            
    //         // Préparer les variables d'environnement pour psql
    //         putenv("PGPASSWORD=\"\"{$dbConfig['password']}\"\"");
            
    //         // Construire la commande psql
    //         $dbCommand = sprintf(
    //             'psql -h %s -U %s -d %s -f %s',
    //             escapeshellarg($dbConfig['host']),
    //             escapeshellarg($dbConfig['username']),
    //             escapeshellarg($dbConfig['database']),
    //             escapeshellarg($backup->file_path_db)
    //         );
            
    //         $returnVar = null;
    //         $output = [];
            
    //         // Exécuter la commande
    //         exec($dbCommand . ' 2>&1', $output, $returnVar);
            
    //         // Nettoyer les variables d'environnement
    //         putenv('PGPASSWORD');
            
    //         if ($returnVar !== 0) {
    //             throw new \Exception('Échec de la restauration de la base de données PostgreSQL: ' . implode("\n", $output));
    //         }
            
    //         // 2. Extraction du fichier de stockage
    //         $storageBackupPath = $backup->file_path_storage;
    //         $storagePath = storage_path('app');
            
    //         // Créer un dossier temporaire pour l'extraction
    //         $tempExtractPath = storage_path('app/temp_restore_' . time());
    //         if (!file_exists($tempExtractPath)) {
    //             mkdir($tempExtractPath, 0755, true);
    //         }
            
    //         // Extraire l'archive
    //         $zip = new \ZipArchive();
    //         if ($zip->open($storageBackupPath) === TRUE) {
    //             $zip->extractTo($tempExtractPath);
    //             $zip->close();
                
    //             // Supprimer le contenu actuel du dossier storage/app
    //             $this->rrmdir($storagePath);
                
    //             // Copier les fichiers extraits
    //             $this->recurse_copy($tempExtractPath . '/storage', $storagePath);
                
    //             // Nettoyer le dossier temporaire
    //             $this->rrmdir($tempExtractPath);
                
    //             return back()->with('success', 'Restauration complète effectuée avec succès !');
    //         } else {
    //             throw new \Exception('Impossible d\'ouvrir l\'archive de stockage');
    //         }
            
    //     } catch (\Exception $e) {
    //         // Nettoyer le dossier temporaire en cas d'erreur
    //         if (isset($tempExtractPath) && file_exists($tempExtractPath)) {
    //             $this->rrmdir($tempExtractPath);
    //         }
    //         return back()->with('error', 'Erreur lors de la restaurationqqq : ' . $e->getMessage());
    //     }
    // }

//     public function restore($id)
// {
//     try {
//         $backup = Backup::findOrFail($id);
        
//         // Vérifier si les fichiers existent
//         if (!file_exists($backup->file_path_db) || !file_exists($backup->file_path_storage)) {
//             return back()->with('error', 'Un ou plusieurs fichiers de sauvegarde sont introuvables.');
//         }

//         $dbConfig = config('database.connections.pgsql');
        
//         // 1. Restauration de la base de données PostgreSQL
//         $connectionString = sprintf(
//             'host=%s port=%s dbname=%s user=%s password=%s',
//             $dbConfig['host'],
//             $dbConfig['port'],
//             $dbConfig['database'],
//             $dbConfig['username'],
//             $dbConfig['password']
//         );

//         $command = sprintf(
//             'psql "%s" -f %s 2>&1',
//             str_replace('"', '\"', $connectionString),
//             escapeshellarg($backup->file_path_db)
//         );

//         $output = [];
//         $returnVar = null;
//         exec($command, $output, $returnVar);

//         if ($returnVar !== 0) {
//             throw new \Exception('Échec de la restauration de la base de données PostgreSQL: ' . implode("\n", $output));
//         }

//         // 2. Extraction du fichier de stockage
//         $storageBackupPath = $backup->file_path_storage;
//         $storagePath = storage_path('app');
        
//         // Créer un dossier temporaire pour l'extraction
//         $tempExtractPath = storage_path('app/temp_restore_' . time());
//         if (!file_exists($tempExtractPath)) {
//             mkdir($tempExtractPath, 0755, true);
//         }
        
//         // Extraire l'archive
//         $zip = new \ZipArchive();
//         if ($zip->open($storageBackupPath) === TRUE) {
//             $zip->extractTo($tempExtractPath);
//             $zip->close();
            
//             // Supprimer le contenu actuel du dossier storage/app
//             $this->rrmdir($storagePath);
            
//             // Copier les fichiers extraits
//             $this->recurse_copy($tempExtractPath . '/storage', $storagePath);
            
//             // Nettoyer le dossier temporaire
//             $this->rrmdir($tempExtractPath);
            
//             return back()->with('success', 'Restauration complète effectuée avec succès !');
//         } else {
//             throw new \Exception('Impossible d\'ouvrir l\'archive de stockage');
//         }
        
//     } catch (\Exception $e) {
//         // Nettoyer le dossier temporaire en cas d'erreur
//         if (isset($tempExtractPath) && file_exists($tempExtractPath)) {
//             $this->rrmdir($tempExtractPath);
//         }
//         return back()->with('error', 'Erreur lors de la restauration : ' . $e->getMessage());
//     }
// }

public function restore($id)
{
    try {
        $backup = Backup::findOrFail($id);
        
        // Vérifier si les fichiers existent
        if (!file_exists($backup->file_path_db) || !file_exists($backup->file_path_storage)) {
            return back()->with('error', 'Un ou plusieurs fichiers de sauvegarde sont introuvables.');
        }

        $dbConfig = config('database.connections.pgsql');
        
        // 1. Restauration de la base de données PostgreSQL
        $connectionString = sprintf(
            'host=%s port=%s dbname=%s user=%s password=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['database'],
            $dbConfig['username'],
            $dbConfig['password']
        );

        $command = sprintf(
            'psql "%s" -f %s 2>&1',
            str_replace('"', '\"', $connectionString),
            escapeshellarg($backup->file_path_db)
        );

        $output = [];
        $returnVar = null;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new \Exception('Échec de la restauration de la base de données PostgreSQL: ' . implode("\n", $output));
        }

        // 2. Extraction du fichier de stockage
        $storageBackupPath = $backup->file_path_storage;
        $storagePath = storage_path('app');
        
        // Créer un dossier temporaire pour l'extraction
        $tempExtractPath = storage_path('app/temp_restore_' . time());
        if (!file_exists($tempExtractPath)) {
            mkdir($tempExtractPath, 0755, true);
        }
        
        // Extraire l'archive
        $zip = new \ZipArchive();
        if ($zip->open($storageBackupPath) === TRUE) {
            // Extraire dans un sous-dossier temp
            $extractTo = $tempExtractPath . '/temp';
            if (!file_exists($extractTo)) {
                mkdir($extractTo, 0755, true);
            }
            
            $zip->extractTo($extractTo);
            $zip->close();
            
            // Supprimer le contenu actuel du dossier storage/app
            $this->rrmdir($storagePath);
            
            // Déterminer le chemin source
            $sourcePath = $extractTo;
            if (is_dir($extractTo . '/storage')) {
                $sourcePath = $extractTo . '/storage';
            } elseif (is_dir($extractTo . '/app')) {
                $sourcePath = $extractTo . '/app';
            }
            
            // Copier les fichiers extraits
            $this->recurse_copy($sourcePath, $storagePath);
            
            // Nettoyer le dossier temporaire
            $this->rrmdir($tempExtractPath);
            
            return back()->with('success', 'Restauration complète effectuée avec succès !');
        } else {
            throw new \Exception('Impossible d\'ouvrir l\'archive de stockage');
        }
        
    } catch (\Exception $e) {
        // Nettoyer le dossier temporaire en cas d'erreur
        if (isset($tempExtractPath) && file_exists($tempExtractPath)) {
            $this->rrmdir($tempExtractPath);
        }
        return back()->with('error', 'Erreur lors de la restauration : ' . $e->getMessage());
    }
}
    
    /**
     * Supprime récursivement un dossier et son contenu
     */
    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object) && !is_link($dir."/".$object))
                        $this->rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }
    
    /**
     * Copie récursive d'un dossier
     */
    private function recurse_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function destroy($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            
            // Supprimer les fichiers de sauvegarde
            $dbFilePath = $backup->file_path_db;
            $storageFilePath = $backup->file_path_storage;
            
            if (file_exists($dbFilePath)) {
                unlink($dbFilePath);
            }
            
            if (file_exists($storageFilePath)) {
                unlink($storageFilePath);
            }
            
            // Supprimer l'entrée de la base de données
            $backup->delete();
            
            return back()->with('success', 'Sauvegarde supprimée avec succès !');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression de la sauvegarde : ' . $e->getMessage());
        }
    }
}
