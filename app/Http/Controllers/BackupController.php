<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\BackupDestination\Backup as BackupFile;
use Spatie\Backup\Helpers\Format;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index()
    {
        $backupFiles = [];
        $backupDestination = BackupDestination::create('local', config('backup.backup.name'));
        
        if ($backupDestination) {
            $backupFiles = collect($backupDestination->backups())
                ->map(function (BackupFile $backup) {
                    return [
                        'path' => $backup->path(),
                        'date' => $backup->date()->format('Y-m-d H:i:s'),
                        'size' => Format::humanReadableSize($backup->size()),
                        'name' => basename($backup->path())
                    ];
                })
                ->sortByDesc('date');
        }

        return view('admin.backups.index', compact('backupFiles'));
    }

    public function create()
    {
        try {
            Artisan::call('backup:run-custom');
            
            return redirect()->back()->with('success', 'Sauvegarde créée avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création de la sauvegarde : ' . $e->getMessage());
        }
    }

    public function download($fileName)
    {
        $file = storage_path('app/' . config('backup.backup.name') . '/' . $fileName);
        
        if (file_exists($file)) {
            return response()->download($file);
        }
        
        return back()->with('error', 'Le fichier de sauvegarde n\'existe pas.');
    }

    public function restore($fileName)
    {
        try {
            $path = storage_path('app/' . config('backup.backup.name') . '/' . $fileName);
            
            // Command to restore database
            $command = "mysql --user=" . config('database.connections.mysql.username') .
                      " --password=" . config('database.connections.mysql.password') .
                      " --host=" . config('database.connections.mysql.host') .
                      " " . config('database.connections.mysql.database') .
                      " < " . $path;

            $returnVar = null;
            $output  = null;
            
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                return back()->with('success', 'Base de données restaurée avec succès !');
            } else {
                return back()->with('error', 'Erreur lors de la restauration de la base de données.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function destroy($fileName)
    {
        $file = storage_path('app/' . config('backup.backup.name') . '/' . $fileName);
        
        if (file_exists($file)) {
            unlink($file);
            return back()->with('success', 'Sauvegarde supprimée avec succès !');
        }
        
        return back()->with('error', 'Le fichier de sauvegarde n\'existe pas.');
    }
}
