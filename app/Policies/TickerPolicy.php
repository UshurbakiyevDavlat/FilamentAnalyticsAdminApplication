<?php

namespace App\Policies;

use App\Models\Ticker;
use App\Models\User;

class TickerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any Ticker');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticker $ticker): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view Ticker');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create Ticker');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticker $ticker): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update Ticker');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticker $ticker): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete Ticker');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticker $ticker): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore Ticker');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticker $ticker): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete Ticker');
    }
}
