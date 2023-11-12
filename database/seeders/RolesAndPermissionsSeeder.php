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
        // $miscPermission = Permission::create(['name' => 'N/A']);

        // USER MODEL
        $create_user = Permission::create(['guard_name' => 'admin', 'name' => 'create: user']);
        $read_user = Permission::create(['guard_name' => 'admin', 'name' => 'read: user']);
        $update_user = Permission::create(['guard_name' => 'admin', 'name' => 'update: user']);
        $delete_user = Permission::create(['guard_name' => 'admin', 'name' => 'delete: user']);

        // PAYMENT MODEL
        $create_payment = Permission::create(['guard_name' => 'admin', 'name' => 'create: payment']);
        $read_payment = Permission::create(['guard_name' => 'admin', 'name' => 'read: payment']);
        $update_payment = Permission::create(['guard_name' => 'admin', 'name' => 'update: payment']);
        $delete_payment = Permission::create(['guard_name' => 'admin', 'name' => 'delete: payment']);

        // BRANCH MODEL
        $create_branch = Permission::create(['guard_name' => 'admin', 'name' => 'create: branch']);
        $read_branch = Permission::create(['guard_name' => 'admin', 'name' => 'read: branch']);
        $update_branch = Permission::create(['guard_name' => 'admin', 'name' => 'update: branch']);
        $delete_branch = Permission::create(['guard_name' => 'admin', 'name' => 'delete: branch']);

        // CUSTOMER PAGE MODEL
        $create_page = Permission::create(['guard_name' => 'admin', 'name' => 'create: page']);
        $read_page = Permission::create(['guard_name' => 'admin', 'name' => 'read: page']);
        $update_page = Permission::create(['guard_name' => 'admin', 'name' => 'update: page']);
        $delete_page = Permission::create(['guard_name' => 'admin', 'name' => 'delete: page']);

        // UNITMODEL MODEL
        $create_unit_model = Permission::create(['guard_name' => 'admin', 'name' => 'create: unit-model']);
        $read_unit_model = Permission::create(['guard_name' => 'admin', 'name' => 'read: unit-model']);
        $update_unit_model = Permission::create(['guard_name' => 'admin', 'name' => 'update: unit-model']);
        $delete_unit_model = Permission::create(['guard_name' => 'admin', 'name' => 'delete: unit-model']);

        // UNIT MODEL
        $create_unit = Permission::create(['guard_name' => 'admin', 'name' => 'create: unit']);
        $read_unit = Permission::create(['guard_name' => 'admin', 'name' => 'read: unit']);
        $update_unit = Permission::create(['guard_name' => 'admin', 'name' => 'update: unit']);
        $delete_unit = Permission::create(['guard_name' => 'admin', 'name' => 'delete: unit']);

        // CUSTOMER APPLICATION
        $create_customer_application = Permission::create(['guard_name' => 'admin', 'name' => 'create: customer-application']);
        $read_customer_application = Permission::create(['guard_name' => 'admin', 'name' => 'read: customer-application']);
        $update_customer_application = Permission::create(['guard_name' => 'admin', 'name' => 'update: customer-application']);
        $delete_customer_application = Permission::create(['guard_name' => 'admin', 'name' => 'delete: customer-application']);

        // ROLE MODEL
        $create_roles = Permission::create(['guard_name' => 'admin', 'name' => 'create: roles']);
        $read_roles = Permission::create(['guard_name' => 'admin', 'name' => 'read: roles']);
        $update_roles = Permission::create(['guard_name' => 'admin', 'name' => 'update: roles']);
        $delete_roles = Permission::create(['guard_name' => 'admin', 'name' => 'delete: roles']);

        // PERMISSION MODEL
        $create_permission = Permission::create(['guard_name' => 'admin', 'name' => 'create: permission']);
        $read_permission = Permission::create(['guard_name' => 'admin', 'name' => 'read: permission']);
        $update_permission = Permission::create(['guard_name' => 'admin', 'name' => 'update: permission']);
        $delete_permission = Permission::create(['guard_name' => 'admin', 'name' => 'delete: permission']);

        // Example with different resource name
        // RELEASE MODEL
        $create_release = Permission::create(['guard_name' => 'admin', 'name' => 'create: release']);
        $read_release = Permission::create(['guard_name' => 'admin', 'name' => 'read: release']);
        $update_release = Permission::create(['guard_name' => 'admin', 'name' => 'update: release']);
        $delete_release = Permission::create(['guard_name' => 'admin', 'name' => 'delete: release']);

        // Example with different resource name
        // LOGS MODEL
        $create_logs = Permission::create(['guard_name' => 'admin', 'name' => 'create: logs']);
        $read_logs = Permission::create(['guard_name' => 'admin', 'name' => 'read: logs']);
        $update_logs = Permission::create(['guard_name' => 'admin', 'name' => 'update: logs']);
        $delete_logs = Permission::create(['guard_name' => 'admin', 'name' => 'delete: logs']);

        
        // // CREATE ROLES
        // $userRole = Role::create(['name' => 'customer'])->syncPermissions([
        //     $miscPermission,
        // ]);

        Role::create(['guard_name' => 'admin', 'name' => 'admin-user'])->syncPermissions([
            // User Permissions
            $create_user, $read_user, $update_user, $delete_user,
        
            // Payment Permissions
            $create_payment, $read_payment, $update_payment, $delete_payment,
        
            // Branch Permissions
            $create_branch, $read_branch, $update_branch, $delete_branch,
        
            // Customer Page Permissions
            $create_page, $read_page, $update_page, $delete_page,
        
            // UnitModel Permissions
            $create_unit_model, $read_unit_model, $update_unit_model, $delete_unit_model,
        
            // Unit Permissions
            $create_unit, $read_unit, $update_unit, $delete_unit,
        
            // Customer Application Permissions
            $create_customer_application, $read_customer_application, $update_customer_application, $delete_customer_application,
        
            // Role Permissions
            $create_roles, $read_roles, $update_roles, $delete_roles,
        
            // Permission Permissions
            $create_permission, $read_permission, $update_permission, $delete_permission,
        
            // Release Permissions
            $create_release, $read_release, $update_release, $delete_release,
        
            // Logs Permissions
            $create_logs, $read_logs, $update_logs, $delete_logs,
        ]);
        

        Role::create(['guard_name' => 'admin', 'name' => 'branch-manager'])->syncPermissions([
            // User Permissions
            $create_user, $read_user, $update_user,
        
            // Payment Permissions
            $create_payment, $read_payment, $update_payment, $delete_payment,
        
            // Branch Permissions
            $create_branch, $read_branch, $update_branch, $delete_branch,
        
            // UnitModel Permissions
            $read_unit_model,
        
            // Unit Permissions
            $create_unit, $read_unit, $update_unit, $delete_unit,
        
            // Customer Application Permissions
            $create_customer_application, $read_customer_application, $update_customer_application, $delete_customer_application,
        
            // Release Permissions
            $create_release, $read_release, $update_release, $delete_release,
        
            // Logs Permissions
            $read_logs,
        ]);
        
        Role::create(['guard_name' => 'admin',  'name' => 'account-officer'])->syncPermissions([

            // Customer Application Permissions
            $create_customer_application, $read_customer_application, $update_customer_application, $delete_customer_application,

            // Logs Permissions
            $read_logs,

        ]);

        Role::create(['guard_name' => 'admin',  'name' => 'sales-clerk'])->syncPermissions([

            // Customer Application Permissions
            $create_customer_application, $read_customer_application, $update_customer_application

        ]);

        Role::create(['guard_name' => 'admin', 'name' => 'cashier'])->syncPermissions([

            // Payment Permissions
            $create_payment, $read_payment,

        ]);

        // $developerRole = Role::create(['guard_name' => 'web', 'name' => 'customer'])->syncPermissions([
        // ]);
        // if(User::query()->where('name', '')->first() != null){
        //     $user = User::query()->where('firstname', 'admin')->first();
        //     $user->assignRole('admin');
        // }

    }
}
