<?php

namespace App\Policies;

use Z3d0X\FilamentFabricator\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    /**
     * Determine whether the user can view any models.
     * Test
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(
            "read: page"
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Page $page): bool
    {
        return $user->hasAnyPermission(
            "view: page"
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(
            "create: page"
        );
    }

}
