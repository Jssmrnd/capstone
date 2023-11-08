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
        // $this->call(RolesAndPermissionsSeeder::class);
        $this->createAdmin();
        // $this->call(RegionSeeder::class);
        // $this->call(ProvinceSeeder::class);
        // $this->call(MunicipalitySeeder::class);
        // $this->call(BarangaySeeder::class);
        // $this->call(BranchSeeder::class);
    }

    private function createAdmin():void{
        $user = User::query()->create([
            'name' => "admin",
            'is_admin' => true,
            'branch_id' => null,
            'gender' => 'male',
            'birthday' => fake()->date('Y-m-d', 'now'),
            'contact_number' => fake()->randomDigit(11),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('branch-manager');
    }
}
