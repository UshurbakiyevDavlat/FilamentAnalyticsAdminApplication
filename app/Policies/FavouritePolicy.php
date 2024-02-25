<?php

namespace App\Policies;

use App\Models\Favourite;
use App\Models\User;

class FavouritePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any Favourite');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Favourite $favourite): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view Favourite');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create Favourite');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Favourite $favourite): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update Favourite');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Favourite $favourite): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete Favourite');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Favourite $favourite): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore Favourite');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Favourite $favourite): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete Favourite');
    }
}
