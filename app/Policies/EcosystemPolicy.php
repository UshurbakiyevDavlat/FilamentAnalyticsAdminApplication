<?php

namespace App\Policies;

use App\Models\Ecosystem;
use App\Models\User;

class EcosystemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any Ecosystem');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ecosystem $ecosystem): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view Ecosystem');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create Ecosystem');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ecosystem $ecosystem): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update Ecosystem');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ecosystem $ecosystem): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete Ecosystem');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ecosystem $ecosystem): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore Ecosystem');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ecosystem $ecosystem): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete Ecosystem');
    }
}
