<?php

namespace App\Policies;

use App\Models\TypePaper;
use App\Models\User;

class TypePaperPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any TypePaper');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TypePaper $typepaper): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view TypePaper');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create TypePaper');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TypePaper $typepaper): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update TypePaper');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TypePaper $typepaper): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete TypePaper');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TypePaper $typepaper): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore TypePaper');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TypePaper $typepaper): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete TypePaper');
    }
}
