<?php

namespace App\Policies;

use App\Models\ActionHistory;
use App\Models\User;

class ActionHistoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any ActionHistory');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ActionHistory $actionhistory): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view ActionHistory');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create ActionHistory');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActionHistory $actionhistory): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update ActionHistory');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActionHistory $actionhistory): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete ActionHistory');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActionHistory $actionhistory): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore ActionHistory');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActionHistory $actionhistory): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete ActionHistory');
    }
}
