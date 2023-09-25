<?php

namespace App\Policies;

use App\Models\UnitModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(
            "read: unit-model"
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UnitModel $unitModel): bool
    {
        return $user->hasAnyPermission(
            "read: unit-model"
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(
            "create: unit-model"
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UnitModel $unitModel): bool
    {
        return $user->hasAnyPermission(
            "update: unit-model"
        );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UnitModel $unitModel): bool
    {
        return $user->hasAnyPermission(
            "delete: unit-model"
        );
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UnitModel $unitModel): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UnitModel $unitModel): bool
    {
        return false;
    }
}
