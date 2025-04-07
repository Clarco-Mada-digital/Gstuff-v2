<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    // Ne logger que les champs modifiés
    protected static $logOnlyDirty = true;

    public static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            $model->logActivity('created');
        });

        static::updated(function (Model $model) {
            $model->logActivity('updated');
        });

        static::deleted(function (Model $model) {
            $model->logActivity('deleted');
        });
    }

    protected function logActivity(string $event)
    {
        ActivityLog::create([
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'event' => $event,
            'causer_type' => auth()->check() ? get_class(auth()->user()) : null,
            'causer_id' => auth()->id(),
            'properties' => $this->getActivityProperties($event),
            'description' => $this->getActivityDescription($event),
            // 'type' => $this->getActivityType($event),
        ]);
    }

    protected function getActivityType(string $event): string
    {
        $modelName = class_basename($this);
        
        return match ($event) {
            'created' => "{$modelName}_created",
            'updated' => "{$modelName}_updated",
            'deleted' => "{$modelName}_deleted",
            default => "{$modelName}_activity",
        };
    }

    protected function getActivityDescription(string $event): string
    {
        $modelName = class_basename($this);
        
        return match ($event) {
            'created' => "Un nouveau {$modelName} a été créé",
            'updated' => "L' {$modelName} a été modifié",
            'deleted' => "L' {$modelName} a été supprimé",
            default => "Activité sur {$modelName}",
        };
    }

    protected function getActivityProperties(string $event): array
    {
        $attributes = $this->toArray();
    
        if (property_exists($this, 'hiddenForActivities')) {
            foreach ($this->hiddenForActivities as $hidden) {
                unset($attributes[$hidden]);
            }
        }
        
        return $event === 'updated'
            ? [
                'old' => $this->getOriginal(),
                'attributes' => $this->getChanges(),
            ]
            : ['attributes' => $this->toArray()];
    }
}