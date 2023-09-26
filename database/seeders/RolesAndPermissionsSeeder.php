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
        // Misc
        $miscPermission = Permission::create(['name' => 'N/A']);

        // USER MODEL
        $userPermission1 = Permission::create(['name' => 'create: user']);
        $userPermission2 = Permission::create(['name' => 'read: user']);
        $userPermission3 = Permission::create(['name' => 'update: user']);
        $userPermission4 = Permission::create(['name' => 'delete: user']);

        // PAYMENT MODEL
        $paymentPermission1 = Permission::create(['name' => 'create: payment']);
        $paymentPermission2 = Permission::create(['name' => 'read: payment']);
        $paymentPermission3 = Permission::create(['name' => 'update: payment']);
        $paymentPermission4 = Permission::create(['name' => 'delete: payment']);
        
        // BRANCH MODEL
        $branchPermission1 = Permission::create(['name' => 'create: branch']);
        $branchPermission2 = Permission::create(['name' => 'read: branch']);
        $branchPermission3 = Permission::create(['name' => 'update: branch']);
        $branchPermission4 = Permission::create(['name' => 'delete: branch']);


        // UNITMODEL MODEL
        $unitModelPermission1 = Permission::create(['name' => 'create: unit-model']);
        $unitModelPermission2 = Permission::create(['name' => 'read: unit-model']);
        $unitModelPermission3 = Permission::create(['name' => 'update: unit-model']);
        $unitModelPermission4 = Permission::create(['name' => 'delete: unit-model']);

        // UNITMODEL MODEL
        $unitPermission1 = Permission::create(['name' => 'create: unit']);
        $unitPermission2 = Permission::create(['name' => 'read: unit']);
        $unitPermission3 = Permission::create(['name' => 'update: unit']);
        $unitPermission4 = Permission::create(['name' => 'delete: unit']);

        // CUSTOMER APPLICATION
        $customerAppPermission1 = Permission::create(['name' => 'create: customer-application']);
        $customerAppPermission2 = Permission::create(['name' => 'read: customer-application']);
        $customerAppPermission3 = Permission::create(['name' => 'update: customer-application']);
        $customerAppPermission4 = Permission::create(['name' => 'delete: customer-application']);

        // ROLE MODEL
        $rolePermission1 = Permission::create(['name' => 'create: role']);
        $rolePermission2 = Permission::create(['name' => 'read: role']);
        $rolePermission3 = Permission::create(['name' => 'update: role']);
        $rolePermission4 = Permission::create(['name' => 'delete: role']);

        // PERMISSION MODEL
        $permission1 = Permission::create(['name' => 'create: permission']);
        $permission2 = Permission::create(['name' => 'read: permission']);
        $permission3 = Permission::create(['name' => 'update: permission']);
        $permission4 = Permission::create(['name' => 'delete: permission']);

        // ADMINS
        $adminPermission1 = Permission::create(['name' => 'read: admin']);
        $adminPermission2 = Permission::create(['name' => 'update: admin']);

        // CREATE ROLES
        $userRole = Role::create(['name' => 'Customer'])->syncPermissions([
            $miscPermission,
        ]);

        $superAdminRole = Role::create(['name' => 'branch-manager'])->syncPermissions([
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

            $adminPermission1,$adminPermission2,$userPermission1,
        ]);
        
        $adminRole = Role::create(['name' => 'acount-officer'])->syncPermissions([

            $customerAppPermission1, $customerAppPermission2, $customerAppPermission3, $customerAppPermission4,

        ]);

        $moderatorRole = Role::create(['name' => 'sales-clerk'])->syncPermissions([

            $paymentPermission1,$paymentPermission2,$paymentPermission3,$paymentPermission4,

            $customerAppPermission1, $customerAppPermission2, $customerAppPermission3, $customerAppPermission4,

        ]);

        $developerRole = Role::create(['name' => 'cashier'])->syncPermissions([

            $paymentPermission1,$paymentPermission2,$paymentPermission3,$paymentPermission4,

        ]);

    }
}
