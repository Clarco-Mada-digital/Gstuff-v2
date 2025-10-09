<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('admin');
    }

    public function create(User $user)
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, User $model)
    {
        // L'admin peut tout modifier sauf lui-même (protection contre l'auto-downgrade)
        return $user->hasRole('admin') && $user->id !== $model->id;
    }

    public function delete(User $user, User $model)
    {
        // On ne peut pas se supprimer soi-même ni supprimer l'admin principal
        return $user->hasRole('admin') && 
               $user->id !== $model->id && 
               $model->id !== 1;
    }
}