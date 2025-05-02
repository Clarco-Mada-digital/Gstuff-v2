<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouleurYeux extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'couleur_yeux';
}
