<?php

namespace App\Policies;

use App\Models\PostType;
use App\Models\User;

class PostTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any PostType');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostType $posttype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view PostType');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create PostType');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostType $posttype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update PostType');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostType $posttype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete PostType');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostType $posttype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore PostType');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostType $posttype): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete PostType');
    }
}
