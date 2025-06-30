<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'media_path', 'media_type', 'expires_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($story) {
            $story->expires_at = now()->addHours(24);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
