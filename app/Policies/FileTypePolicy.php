<?php

namespace App\Policies;

use App\Models\FileType;
use App\Models\User;

class FileTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any FileType');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FileType $filetype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view FileType');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create FileType');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FileType $filetype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update FileType');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FileType $filetype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete FileType');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FileType $filetype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore FileType');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FileType $filetype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete FileType');
    }
}
