<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistanceMax extends Model
{
    use HasFactory;
    protected $table = 'distance_max';
    protected $fillable = ['distance_max'];
}
