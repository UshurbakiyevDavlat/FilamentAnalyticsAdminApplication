<?php

namespace App\Policies;

use App\Models\PostTranslation;
use App\Models\User;

class PostTranslationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any PostTranslation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PostTranslation $posttranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view PostTranslation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create PostTranslation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PostTranslation $posttranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update PostTranslation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PostTranslation $posttranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete PostTranslation');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostTranslation $posttranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore PostTranslation');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostTranslation $posttranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete PostTranslation');
    }
}
