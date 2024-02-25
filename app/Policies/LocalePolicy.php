<?php

namespace App\Policies;

use App\Models\Locale;
use App\Models\User;

class LocalePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any Locale');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Locale $locale): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view Locale');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create Locale');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Locale $locale): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update Locale');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Locale $locale): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete Locale');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Locale $locale): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore Locale');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Locale $locale): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete Locale');
    }
}
