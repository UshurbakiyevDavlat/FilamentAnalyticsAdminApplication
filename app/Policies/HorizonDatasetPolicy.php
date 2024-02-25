<?php

namespace App\Policies;

use App\Models\HorizonDataset;
use App\Models\User;

class HorizonDatasetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view-any HorizonDataset');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HorizonDataset $horizondataset): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'view HorizonDataset');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'create HorizonDataset');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HorizonDataset $horizondataset): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'update HorizonDataset');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HorizonDataset $horizondataset): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'delete HorizonDataset');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HorizonDataset $horizondataset): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'restore HorizonDataset');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HorizonDataset $horizondataset): bool
    {
        return $user->getPermissionsViaRoles()->contains('name', 'force-delete HorizonDataset');
    }
}
