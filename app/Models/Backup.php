<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Backup extends Model
{
    use HasFactory;

    public const TYPE_DATABASE = 'database';
    public const TYPE_STORAGE = 'storage';
    public const TYPE_FULL = 'full';

    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';
    public const STATUS_IN_PROGRESS = 'in_progress';

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'file_path_db',
        'file_name_db',
        'file_path_storage',
        'file_name_storage',
        'type',
        'size_db',
        'size_storage',
        'disk',
        'status',
        'error_message',
        'metadata',
        'user_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'size_db' => 'integer',
        'size_storage' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur qui a effectué la sauvegarde
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le chemin complet du fichier de sauvegarde
     */
    public function getFullPathAttribute($value): string
    {
        $disk = Storage::disk($this->disk);
        return $disk->path($value);
    }

    /**
     * Obtenir la taille formatée de la sauvegarde
     */
    public function getFormattedSizeAttribute($value): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($value, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
