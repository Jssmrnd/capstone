<?php

namespace App\Policies;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;


/** 
 * Yo pre papaltan nalang ng mga laman nito
 * 
 * sa class Ex. yung PermissionPolicy
 * 
 * bukod na file kada bagong class.
 * class BranchPolicy, UnitPolicy, UnitModelPolicy, UtitlitiesPolicy
 * 
 * Ex.
 * read: permissions
 * update: permissions
 * delete: permission
 * 
 * Kapag nasa BranchPolicy 
 * Ex.
 * read: branch
 * update: branch
 * delete: branch
*/

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(
            "read: permission"
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permission): bool
    {
        return $user->hasAnyPermission(
            "read: permission"
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(
            "create: permission"
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->hasAnyPermission(
            "update: permission"
        );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $user->hasAnyPermission(
            "delete: permission"
        );
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission $permission): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission $permission): bool
    {
        return false;
    }
}
