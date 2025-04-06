<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'type' => 'user_created',
            'description' => 'a créé un nouvel utilisateur',
            'data' => [
                'user_id' => $user->id,
                'pseudo' => $user->pseudo
            ]
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->isDirty('roles')) {
            ActivityLog::create([
                'subject_type' => User::class,
                'subject_id' => $user->id,
                'event' => 'attached',
                'parent_type' => Role::class,
                'parent_id' => $user->roles->first()->id,
                'description' => "Rôle associé à l'utilisateur",
            ]);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
