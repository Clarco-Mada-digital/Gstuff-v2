<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CouleurCheveux extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'couleur_cheveux_id');
    }
}
