<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PratiqueSexuelle extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug',
        'is_active'
    ];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'pratique_sexuelle_id');
    }
}
