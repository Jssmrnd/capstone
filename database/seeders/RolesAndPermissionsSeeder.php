<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        //\App\Models\CustomerApplication::factory(10)->create();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create a manager role for users authenticating with the admin guard:
        // $role = Role::create(['guard_name' => 'admin', 'name' => 'manager']);

        // // Define a `publish articles` permission for the admin users belonging to the admin guard
        // $permission = Permission::create(['guard_name' => 'admin', 'name' => 'publish articles']);

        // // Define a *different* `publish articles` permission for the regular users belonging to the web guard
        // $permission = Permission::create(['guard_name' => 'web', 'name' => 'publish articles']);

        // Misc
        $miscPermission = Permission::create(['name' => 'N/A']);

        // USER MODEL
        $userPermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: user']);
        $userPermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: user']);
        $userPermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: user']);
        $userPermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: user']);

        // PAYMENT MODEL
        $paymentPermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: payment']);
        $paymentPermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: payment']);
        $paymentPermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: payment']);
        $paymentPermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: payment']);
        
        // BRANCH MODEL
        $branchPermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: branch']);
        $branchPermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: branch']);
        $branchPermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: branch']);
        $branchPermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: branch']);

        // CUSTOMER PAGE MODEL
        $unitPermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: page']);
        $unitPermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: page']);
        $unitPermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: page']);
        $unitPermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: page']);

        // UNITMODEL MODEL
        $unitModelPermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: unit-model']);
        $unitModelPermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: unit-model']);
        $unitModelPermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: unit-model']);
        $unitModelPermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: unit-model']);

        // UNIT MODEL
        $unitPermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: unit']);
        $unitPermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: unit']);
        $unitPermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: unit']);
        $unitPermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: unit']);

        // CUSTOMER APPLICATION
        $customerAppPermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: customer-application']);
        $customerAppPermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: customer-application']);
        $customerAppPermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: customer-application']);
        $customerAppPermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: customer-application']);

        // ROLE MODEL
        $rolePermission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: roles']);
        $rolePermission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: roles']);
        $rolePermission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: roles']);
        $rolePermission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: roles']);

        // PERMISSION MODEL
        $permission1 = Permission::create(['guard_name' => 'admin', 'name' => 'create: permission']);
        $permission2 = Permission::create(['guard_name' => 'admin', 'name' => 'read: permission']);
        $permission3 = Permission::create(['guard_name' => 'admin', 'name' => 'update: permission']);
        $permission4 = Permission::create(['guard_name' => 'admin', 'name' => 'delete: permission']);

        
        // CREATE ROLES
        $userRole = Role::create(['name' => 'customer'])->syncPermissions([
            $miscPermission,
        ]);

        $branch_manager = Role::create(['guard_name' => 'admin', 'name' => 'branch-manager'])->syncPermissions([
            $userPermission1,       //create: user
            $userPermission2,       //read: user
            $userPermission3,       //update: user
            $userPermission4,       //delete: user

            $paymentPermission1,$paymentPermission2,$paymentPermission3,$paymentPermission4,

            $branchPermission1,$branchPermission2,$branchPermission3,$branchPermission4,

            $unitModelPermission1,$unitModelPermission2,$unitModelPermission3,$unitModelPermission4,

            $unitPermission1,$unitPermission2,$unitPermission3,$unitPermission4,

            $customerAppPermission1, $customerAppPermission2, $customerAppPermission3, $customerAppPermission4,

            $rolePermission1,$rolePermission2,$rolePermission3,$rolePermission4,

            $permission1,$permission2,$permission3,$permission4,
        ]);
        
        $adminRole = Role::create(['guard_name' => 'admin',  'name' => 'acount-officer'])->syncPermissions([

            $customerAppPermission1, $customerAppPermission2, $customerAppPermission3, $customerAppPermission4,

        ]);

        $moderatorRole = Role::create(['guard_name' => 'admin',  'name' => 'sales-clerk'])->syncPermissions([

            $paymentPermission1,$paymentPermission2,$paymentPermission3,$paymentPermission4,

            $customerAppPermission1, $customerAppPermission2, $customerAppPermission3, $customerAppPermission4,

        ]);

        $developerRole = Role::create(['guard_name' => 'admin', 'name' => 'cashier'])->syncPermissions([

            $paymentPermission1,$paymentPermission2,$paymentPermission3,$paymentPermission4,

        ]);

        $developerRole = Role::create(['guard_name' => 'admin', 'name' => 'customer'])->syncPermissions([

            $paymentPermission1, $paymentPermission2, $customerAppPermission1, $customerAppPermission2

        ]);

        if(User::query()->where('name', 'admin')->first() != null){
            $user = User::query()->where('name', 'admin')->first();
            $user->assignRole('branch-manager');
        }

    }
}
