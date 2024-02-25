<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;

class StatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any Status');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Status $status): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view Status');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create Status');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Status $status): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update Status');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Status $status): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete Status');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Status $status): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore Status');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Status $status): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete Status');
    }
}
