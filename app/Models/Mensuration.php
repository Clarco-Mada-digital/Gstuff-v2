<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Mensuration extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'mensuration_id');
    }
}
