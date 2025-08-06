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
use Illuminate\Support\Facades\Auth;

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

             // Verify password (you might want to verify against the current user's password)
            if (!\Hash::check($request->password, auth()->user()->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mot de passe incorrect.'
                ], 401);
            }

            $backup = Backup::findOrFail($id);
            logger()->info('🔍 Sauvegarde sélectionnée', ['backup' => $backup]);

            $directorySeparator = DIRECTORY_SEPARATOR;
            $normalizedFilePathDb = str_replace(['/', '\\'], $directorySeparator, $backup->file_path_db);
            $normalizedFilePathStorage = str_replace(['/', '\\'], $directorySeparator, $backup->file_path_storage);

            if (!file_exists($normalizedFilePathDb) || !file_exists($normalizedFilePathStorage)) {
                logger()->warning('⚠️ Fichiers de sauvegarde introuvables', [
                    'file_path_db_exists' => file_exists($normalizedFilePathDb),
                    'file_path_db' => $normalizedFilePathDb,
                    'file_path_storage_exists' => file_exists($normalizedFilePathStorage),
                    'file_path_storage' => $normalizedFilePathStorage
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
            return response()->json([
                'success' => true,
                'message' => 'Restauration terminée avec succès.',
            ], 200);

        } catch (\Exception $e) {
            logger()->error('❌ Restauration échouée', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Restoration failed: ' . $e->getMessage()
            ], 500);
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


    public function Upload(Request $request)
    {
        try {
            $request->validate([
                'db_file' => [
                    'required',
                    'file',
                    function ($attribute, $value, $fail) {
                        if (!$value->isValid()) {
                            $fail("Le fichier n'est pas valide.");
                            return;
                        }

                        $extension = strtolower($value->getClientOriginalExtension());
                        if (!in_array($extension, ['sql', 'gz'])) {
                            $fail("Le fichier doit être de type .sql ou .gz");
                        }
                    },
                ],
                'storage_file' => 'nullable|file|mimes:zip|max:1024000',
            ]);

            // Créer le dossier backups s'il n'existe pas
            $backupDir = storage_path('app/backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Sauvegarder le fichier de base de données
            $dbFile = $request->file('db_file');
            $dbExtension = $dbFile->getClientOriginalExtension();
            $dbFileName = 'db_backup_' . now()->format('Y_m_d_His') . '.' . $dbExtension;
            $dbPath = $dbFile->storeAs('backups', $dbFileName);
            $fullDbPath = storage_path('app/' . $dbPath);

            // Sauvegarder le fichier de stockage s’il est fourni
            $storagePath = null;
            $storageFileName = null;
            $fullStoragePath = null;

            if ($request->hasFile('storage_file')) {
                $storageFile = $request->file('storage_file');
                $storageFileName = 'storage_backup_' . now()->format('Y_m_d_His') . '.zip';
                $storagePath = $storageFile->storeAs('backups', $storageFileName);
                $fullStoragePath = storage_path('app/' . $storagePath);
            }


            $normalizedDbPath = str_replace('\\', '/', $fullDbPath);
            $normalizedStoragePath = str_replace('\\', '/', $fullStoragePath);

            // Créer l'enregistrement dans la base de données
            $backup = Backup::create([
                'name' => 'Upload ' . now()->format('d/m/Y H:i:s'),
                'type' => Backup::TYPE_FULL,
                'status' => Backup::STATUS_COMPLETED,
                'file_path_db' =>  dirname($normalizedDbPath) . '/' . basename($normalizedDbPath),
                'file_name_db' =>  basename($normalizedDbPath),
                'file_path_storage' => dirname($normalizedStoragePath) . '/' . basename($normalizedStoragePath),
                'file_name_storage' =>  basename($normalizedStoragePath),
                'size_db' => filesize($fullDbPath),
                'size_storage' => $fullStoragePath ? filesize($fullStoragePath) : null,
                'disk' => 'local',
                'metadata' => [
                    'started_at' => now(),
                    'source' => Auth::id() ? 'user' : 'system',
                    'is_uploaded' => true,
                ],
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Fichiers sauvegardés avec succès dans le dossier backups.',
                'backup' => $backup,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l’upload: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Restore database from SQL file
     */
    protected function restoreDatabase($filePath)
    {
        $dbConfig = config('database.connections.pgsql');
        
        $connectionString = sprintf(
            'host=%s port=%s dbname=%s user=%s password=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['database'],
            $dbConfig['username'],
            $dbConfig['password']
        );

        // Prepare SQL file
        $modifiedSqlPath = $this->prepareSqlForRestore($filePath);

        $command = sprintf(
            'psql "%s" -f %s 2>&1',
            str_replace('"', '\"', $connectionString),
            escapeshellarg($modifiedSqlPath)
        );

        $output = [];
        $returnVar = null;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new \Exception('Échec de la restauration PostgreSQL : ' . implode("\n", $output));
        }

        if (file_exists($modifiedSqlPath)) {
            unlink($modifiedSqlPath);
        }
    }

    /**
     * Extract GZIP file
     */
    protected function extractGzip($source, $destination)
    {
        $bufferSize = 4096;
        $file = gzopen($source, 'rb');
        $outFile = fopen($destination, 'wb');

        if (!$file || !$outFile) {
            throw new \Exception('Impossible d\'ouvrir les fichiers pour l\'extraction.');
        }

        while (!gzeof($file)) {
            fwrite($outFile, gzread($file, $bufferSize));
        }

        gzclose($file);
        fclose($outFile);
    }

    /**
     * Delete directory recursively
     */
    protected function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
