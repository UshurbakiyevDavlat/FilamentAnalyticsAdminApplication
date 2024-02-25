<?php

namespace App\Policies;

use App\Models\Action;
use App\Models\User;

class ActionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any Action');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Action $action): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view Action');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create Action');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Action $action): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update Action');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Action $action): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete Action');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Action $action): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore Action');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Action $action): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete Action');
    }
}
