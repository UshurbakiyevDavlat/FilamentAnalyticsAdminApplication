<?php

namespace App\Policies;

use App\Models\Isin;
use App\Models\User;

class IsinPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any Isin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Isin $isin): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view Isin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create Isin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Isin $isin): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update Isin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Isin $isin): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete Isin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Isin $isin): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore Isin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Isin $isin): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete Isin');
    }
}
