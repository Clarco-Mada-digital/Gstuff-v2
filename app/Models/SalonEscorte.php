<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalonEscorte extends Model
{
    use HasFactory;
    protected $table = 'salon_escorte';

    protected $fillable = [
        'salon_id',
        'escorte_id',
    ];

    /**
     * Obtenir le salon associé.
     */
    public function salon()
    {
        return $this->belongsTo(User::class, 'salon_id');
    }

    /**
     * Obtenir l'escorte associée.
     */
    public function escorte()
    {
        return $this->belongsTo(User::class, 'escorte_id');
    }
}
