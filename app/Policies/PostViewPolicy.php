<?php

namespace App\Policies;

use App\Models\PostView;
use App\Models\User;

class PostViewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any PostView');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostView $postview): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view PostView');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create PostView');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostView $postview): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update PostView');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostView $postview): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete PostView');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostView $postview): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore PostView');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostView $postview): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete PostView');
    }
}
