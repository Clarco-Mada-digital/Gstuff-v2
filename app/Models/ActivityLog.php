<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Cache;

class ActivityLog extends Model
{
    use HasFactory, Prunable;

    protected $guarded = [];
    protected $casts = [
        'properties' => 'collection',
    ];
    // protected $hiddenForActivities = [
    //     'password',
    //     'remember_token',
    //     'credit_card'
    // ];

    protected static function booted()
    {
        // static::created(function (ActivityLog $activity) {
        //     Cache::tags(['activity-feed'])->forget("user-{$activity->causer_id}-activities");
        // });
    }

    public function scopeForUser($query, $userId)
    {
        return Cache::tags(['activity-feed'])->remember(
            "user-{$userId}-activities",
            now()->addHour(),
            fn() => $query->where('causer_id', $userId)->latest()->take(10)->get()
        );
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->morphTo();
    }

    public function getExtraProperty($key)
    {
        return $this->properties->get($key);
    }
    
    public function scopeForSubject(Builder $query, Model $subject)
    {
        return $query->where('subject_type', get_class($subject))
                    ->where('subject_id', $subject->id);
    }

    public function scopeCausedBy(Builder $query, Model $causer)
    {
        return $query->where('causer_type', get_class($causer))
                    ->where('causer_id', $causer->id);
    }

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subMonths(
            config('activity.retention_months', 3)
        ));
    }

    public function scopeInLog($query, $logName)
    {
        return $query->where('log_name', $logName);
    }
}
