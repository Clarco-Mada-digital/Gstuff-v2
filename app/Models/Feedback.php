<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    public $timestamps = true;

    protected $fillable = [
        'userToId',
        'userFromId',
        'rating',
        'comment',
    ];

    public function userFromId(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
