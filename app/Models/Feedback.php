<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Feedback extends Model
{
    use HasFactory,HasTranslations;

    protected $table = 'feedbacks';
    public $timestamps = true;

    protected $fillable = [
        'userToid',
        'userFromid',
        'rating',
        'comment',
    ];

    public $translatable = ['comment'];


    public function userFrom(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userFromid');
    }
    
    public function userTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userToid');
    }
}
