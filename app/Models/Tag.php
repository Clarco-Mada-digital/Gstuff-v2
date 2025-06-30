<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['name','slug'];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
