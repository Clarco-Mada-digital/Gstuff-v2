<?php
// app/Models/Commentaire.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Commentaire extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['content', 'user_id', 'is_approved'];
    public $translatable = ['content'];

    // Relation : Un commentaire appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
