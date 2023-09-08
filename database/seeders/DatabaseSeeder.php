<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\CustomerApplication::factory(10)->create();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Misc
        // $miscPermission = Permission::create(['name' => 'N/A']);

        // // USER MODEL
        // $userPermission1 = Permission::create(['name' => 'create: user']);
        // $userPermission2 = Permission::create(['name' => 'read: user']);
        // $userPermission3 = Permission::create(['name' => 'update: user']);
        // $userPermission4 = Permission::create(['name' => 'delete: user']);

        // // ROLE MODEL
        // $rolePermission1 = Permission::create(['name' => 'create: role']);
        // $rolePermission2 = Permission::create(['name' => 'read: role']);
        // $rolePermission3 = Permission::create(['name' => 'update: role']);
        // $rolePermission4 = Permission::create(['name' => 'delete: role']);

        // // PERMISSION MODEL
        // $permission1 = Permission::create(['name' => 'create: permission']);
        // $permission2 = Permission::create(['name' => 'read: permission']);
        // $permission3 = Permission::create(['name' => 'update: permission']);
        // $permission4 = Permission::create(['name' => 'delete: permission']);

        // // ADMINS
        // $adminPermission1 = Permission::create(['name' => 'read: admin']);
        // $adminPermission2 = Permission::create(['name' => 'update: admin']);

        // // CREATE ROLES
        // $userRole = Role::create(['name' => 'user'])->syncPermissions([
        //     $miscPermission,
        // ]);

        // $superAdminRole = Role::create(['name' => 'super-admin'])->syncPermissions([
        //     $userPermission1,
        //     $userPermission2,
        //     $userPermission3,
        //     $userPermission4,
        //     $rolePermission1,
        //     $rolePermission2,
        //     $rolePermission3,
        //     $rolePermission4,
        //     $permission1,
        //     $permission2,
        //     $permission3,
        //     $permission4,
        //     $adminPermission1,
        //     $adminPermission2,
        //     $userPermission1,
        // ]);
        // $adminRole = Role::create(['name' => 'admin'])->syncPermissions([
        //     $userPermission1,
        //     $userPermission2,
        //     $userPermission3,
        //     $userPermission4,
        //     $rolePermission1,
        //     $rolePermission2,
        //     $rolePermission3,
        //     $rolePermission4,
        //     $permission1,
        //     $permission2,
        //     $permission3,
        //     $permission4,
        //     $adminPermission1,
        //     $adminPermission2,
        //     $userPermission1,
        // ]);
        // $moderatorRole = Role::create(['name' => 'moderator'])->syncPermissions([
        //     $userPermission2,
        //     $rolePermission2,
        //     $permission2,
        //     $adminPermission1,
        // ]);
        // $developerRole = Role::create(['name' => 'developer'])->syncPermissions([
        //     $adminPermission1,
        // ]);

        $developerRole = Role::findByName('developer');
        $moderatorRole = Role::findByName('moderator');
        $adminRole = Role::findByName('admin');
        $superAdminRole = Role::findByName('super-admin');
        $userRole = Role::findByName('user');

        // CREATE ADMINS & USERS
        User::create([
            'name' => 'super admin',
            'employee_id' => 1000001,
            'is_admin' => 1,
            'email' => 'super@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($superAdminRole);

        User::create([
            'name' => 'admin',
            'employee_id' => 1000002,
            'is_admin' => 1,
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($adminRole);

        User::create([
            'name' => 'moderator',
            'employee_id' => 1000003,
            'is_admin' => 1,
            'email' => 'moderator@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($moderatorRole);

        User::create([
            'name' => 'developer',
            'employee_id' => 1000004,
            'is_admin' => 1,
            'email' => 'developer@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($developerRole);

        for ($i=1; $i < 50; $i++) {
            User::create([
                'name' => 'Test '.$i,
                'employee_id' => 1000004+$i,
                'is_admin' => 0,
                'email' => 'test'.$i.'@test.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // password
                'remember_token' => Str::random(10),
            ])->assignRole($userRole);
        }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
