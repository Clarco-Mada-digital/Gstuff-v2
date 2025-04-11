<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;
    
    protected $fillable = ['content', 'user_id', 'is_approved'];

    // Relation : Un commentaire appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
