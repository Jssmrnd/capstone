<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Branch;
use App\Models\CustomerApplication;
use App\Models\Payment;
use App\Models\UnitModel;
use App\Models\User;
use App\Policies\BranchPolicy;
use App\Policies\CustomerApplicationPolicy;
use Z3d0X\FilamentFabricator\Models\Page;
use App\Policies\PagePolicy;
use App\Policies\PaymentsPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolesPolicy;
use App\Policies\UnitModelPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,                               //User Module
        Page::class => PagePolicy::class,                               //Page Module/ Customer Website Maintenance
        CustomerApplication::class => CustomerApplicationPolicy::class, // Customer Application Module
        Payment::class => PaymentsPolicy::class,                        // Payment Module
        Role::class => RolesPolicy::class,                              // Role Module
        Permission::class => PermissionPolicy::class,                   // Permission Module
        Branch::class => BranchPolicy::class,                           // Branch Module
        UnitModel::class => UnitModelPolicy::class,                     // UnitModel Module
        Unit::class => UnitPolicy::class,                               // UnitModel Module
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
