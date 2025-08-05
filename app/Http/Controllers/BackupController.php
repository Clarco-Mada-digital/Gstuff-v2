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

public function restore(Request $request)
{
    try {
        $id = $request->input('id');
        $password = $request->input('password');

        $request->validate([
            'id' => 'required|exists:backups,id',
            'password' => 'required|string'
        ]);

        $backup = Backup::findOrFail($id);
        logger()->info('🔍 Sauvegarde sélectionnée', ['backup' => $backup]);

        $directorySeparator = DIRECTORY_SEPARATOR;
        $normalizedFilePathDb = str_replace(['/', '\\'], $directorySeparator, $backup->file_path_db);
        $normalizedFilePathStorage = str_replace(['/', '\\'], $directorySeparator, $backup->file_path_storage);

        if (!file_exists($normalizedFilePathDb) || !file_exists($normalizedFilePathStorage)) {
            logger()->warning('⚠️ Fichiers de sauvegarde introuvables', [
                'file_path_db_exists' => file_exists($normalizedFilePathDb),
                'file_path_storage_exists' => file_exists($normalizedFilePathStorage)
            ]);
            return back()->with('error', 'Un ou plusieurs fichiers de sauvegarde sont introuvables.');
        }

        logger()->info('📁 Fichiers de sauvegarde trouvés', [
            'file_path_db' => $normalizedFilePathDb,
            'file_path_storage' => $normalizedFilePathStorage
        ]);

        $dbConfig = config('database.connections.pgsql');
        logger()->info('🔧 Configuration PostgreSQL', ['dbConfig' => $dbConfig]);

        $connectionString = sprintf(
            'host=%s port=%s dbname=%s user=%s password=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['database'],
            $dbConfig['username'],
            $dbConfig['password']
        );

        // 🧠 Prétraitement du fichier SQL
        $modifiedSqlPath = $this->prepareSqlForRestore($normalizedFilePathDb);
        logger()->info('📄 Fichier SQL modifié prêt', ['modifiedSqlPath' => $modifiedSqlPath]);

        $command = sprintf(
            'psql "%s" -f %s 2>&1',
            str_replace('"', '\"', $connectionString),
            escapeshellarg($modifiedSqlPath)
        );

        logger()->info('🚀 Commande psql exécutée', ['command' => $command]);

        $output = [];
        $returnVar = null;
        exec($command, $output, $returnVar);

        logger()->info('📜 Résultat restauration PostgreSQL', [
            'output' => $output,
            'returnVar' => $returnVar
        ]);

        if ($returnVar !== 0) {
            throw new \Exception('Échec restauration PostgreSQL : ' . implode("\n", $output));
        }

        if (file_exists($modifiedSqlPath)) {
            unlink($modifiedSqlPath);
            logger()->info('🧹 Fichier temporaire supprimé', ['path' => $modifiedSqlPath]);
        }

        logger()->info('✅ Restauration terminée avec succès');

        // 🔁 Restauration du dossier storage
        $result = $this->restoreStorageFromZip($normalizedFilePathStorage);

        if (!$result) {
            return back()->with('error', 'La base de données a été restaurée, mais la restauration du dossier storage a échoué.');
        }
        $countBackups = Backup::count();
        Artisan::call('backup:run-custom');
        return back()->with('success', 'Restauration de la base de données réussie.');

    } catch (\Exception $e) {
        logger()->error('❌ Restauration échouée', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'Restoration failed: ' . $e->getMessage());
    }
}
public function prepareSqlForRestore($filePath)
{
    $lines = file($filePath);
    $seenObjects = [];
    $newLines = [];

    foreach ($lines as $line) {
        $trimmed = trim($line);

        // CREATE TABLE
        if (preg_match('/^CREATE TABLE\s+(\w+)\.(\w+)/i', $trimmed, $matches)) {
            $schema = $matches[1];
            $table = $matches[2];
            $objectKey = "table:{$schema}.{$table}";
            if (!isset($seenObjects[$objectKey])) {
                $newLines[] = "DROP TABLE IF EXISTS {$schema}.{$table} CASCADE;";
                $seenObjects[$objectKey] = true;
            }
        }

        // CREATE SEQUENCE
        if (preg_match('/^CREATE SEQUENCE\s+(\w+)\.(\w+)/i', $trimmed, $matches)) {
            $schema = $matches[1];
            $sequence = $matches[2];
            $objectKey = "sequence:{$schema}.{$sequence}";
            if (!isset($seenObjects[$objectKey])) {
                $newLines[] = "DROP SEQUENCE IF EXISTS {$schema}.{$sequence} CASCADE;";
                $seenObjects[$objectKey] = true;
            }
        }

        // CREATE INDEX
        if (preg_match('/^CREATE INDEX\s+("?[\w_]+"?)\s+ON\s+(\w+)\.(\w+)/i', $trimmed, $matches)) {
            $indexName = $matches[1];
            $objectKey = "index:{$indexName}";
            if (!isset($seenObjects[$objectKey])) {
                $newLines[] = "DROP INDEX IF EXISTS {$indexName};";
                $seenObjects[$objectKey] = true;
            }
        }

        $newLines[] = $line;
    }

    $tempPath = storage_path('app/temp_restore_' . time() . '.sql');
    file_put_contents($tempPath, implode("", $newLines));
    logger()->info('📄 Prétraitement SQL avec dédoublonnage terminé', ['tempPath' => $tempPath]);

    return $tempPath;
}

public function restoreStorageFromZip($storageZipPath)
{
    try {
        $storagePath = storage_path('app');
        $tempExtractPath = $storagePath . '/temp_restore_' . time();

        // Créer le dossier temporaire
        if (!file_exists($tempExtractPath)) {
            mkdir($tempExtractPath, 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($storageZipPath) === TRUE) {

            // 📦 Extraction dans le dossier temporaire directement
            $zip->extractTo($tempExtractPath);
            $zip->close();

            logger()->info('📂 Extraction terminée', ['chemin' => $tempExtractPath]);

             // 🧼 Supprimer le contenu actuel du storage/app mais conserver le dossier temporaire
             foreach (glob($storagePath . '/*') as $item) {
                // Exclure le dossier temporaire
                if (realpath($item) === realpath($tempExtractPath)) {
                    continue;
                }

                is_dir($item) ? $this->rrmdir($item) : unlink($item);
            }

            // 🔍 Détecter automatiquement les dossiers 'public' et 'backups' dans le zip
            $expectedFolders = ['public', 'backups'];
            foreach ($expectedFolders as $folder) {
                $source = $tempExtractPath . DIRECTORY_SEPARATOR . $folder;
                if (is_dir($source)) {
                    $this->recurse_copy($source, $storagePath . DIRECTORY_SEPARATOR . $folder);
                    logger()->info("📁 Dossier restauré : {$folder} ==> {$source}");
                } else {
                    logger()->warning("⚠️ Dossier manquant dans le ZIP : {$folder} ==> {$source}");
                }
            }

            // 🔗 Recréer le lien symbolique si nécessaire
            Artisan::call('storage:link');
            logger()->info('🔗 Lien symbolique public/storage recréé');

            // 🧹 Nettoyage temporaire
            $this->rrmdir($tempExtractPath);

            logger()->info('✅ Restauration complète du storage effectuée');
            return true;

        } else {
            throw new \Exception("Impossible d'ouvrir l'archive ZIP du storage : {$storageZipPath}");
        }

    } catch (\Exception $e) {
        logger()->error('❌ Erreur restauration storage', [
            'error' => $e->getMessage(),
        ]);
        return false;
    }
}


public function rrmdir($dir)
{
    if (!is_dir($dir)) return;
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        is_dir($path) ? $this->rrmdir($path) : unlink($path);
    }
    rmdir($dir);
}

public function recurse_copy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    while (($file = readdir($dir)) !== false) {
        if ($file == '.' || $file == '..') continue;
        $srcPath = $src . DIRECTORY_SEPARATOR . $file;
        $dstPath = $dst . DIRECTORY_SEPARATOR . $file;
        is_dir($srcPath) ? $this->recurse_copy($srcPath, $dstPath) : copy($srcPath, $dstPath);
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
