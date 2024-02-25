<?php

namespace App\Policies;

use App\Models\CategoryTranslation;
use App\Models\User;

class CategoryTranslationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any CategoryTranslation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CategoryTranslation $categorytranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view CategoryTranslation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create CategoryTranslation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CategoryTranslation $categorytranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update CategoryTranslation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CategoryTranslation $categorytranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete CategoryTranslation');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CategoryTranslation $categorytranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore CategoryTranslation');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CategoryTranslation $categorytranslation): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete CategoryTranslation');
    }
}
