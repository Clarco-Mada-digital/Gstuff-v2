<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID comme clé primaire
    protected $keyType = 'string';

    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Relation polymorphique : une notification peut appartenir à différents modèles (User, etc.)
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
