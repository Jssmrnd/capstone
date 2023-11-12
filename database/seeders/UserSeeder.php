<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdmins();
        $this->createBalayanEmployees();
    }

    private function createAdmins(): void
    {
        $user_1 = User::query()->create([
            "firstname" => "John Carlo",
            "lastname" => "Evasco",
            "password" => bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" => "antugaevasco@gmail.com",
            "gender" => "male",
            "contact_number" => "09154977008",
            "is_admin" => true,
        ]);
        $user_1->assignRole("admin-user");
        $user_2 = User::query()->create([
            "firstname" => "Jess Gabriel",
            "lastname" => "Miranda",
            "password" => bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" => "jessmiranda0429@gmail.com",
            "gender" => "male",
            "contact_number" => "09476256034",
            "is_admin" => true,
        ]);
        $user_2->assignRole("admin-user");
        $user_3 = User::query()->create([
            "firstname" => "John Rovic ",
            "lastname" => "Samonte",
            "password" =>bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" =>"rovics123@gmail.com",
            "gender" => "male",
            "contact_number" => "09975388634",
            "is_admin" => true,
        ]);
        $user_3->assignRole("admin-user");
        $user_4 = User::query()->create([
            "firstname" => "Ernielouyd",
            "lastname" => "Macatangay",
            "password" => bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" => "yot.macatangay14@gmail.com",
            "gender" => "male",
            "contact_number" => "09156669619",
            "is_admin" => true,
        ]);
        $user_4->assignRole("admin-user");
    }

    private function createBalayanEmployees(): void
    {
        $user_1 = User::query()->create([
            "firstname" => "Ms. Sales",
            "lastname" => "Clerk",
            "password" => bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" => "salesclerk@gmail.com",
            "gender" => "female",
            "contact_number" => "09154977009",
            "is_admin" => true,
        ]);
        $user_1->assignRole("sales-clerk");
        $user_2 = User::query()->create([
            "firstname" => "Mr. Account",
            "lastname" => "Officer",
            "password" => bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" => "account.officer@gmail.com",
            "gender" => "male",
            "contact_number" => "09476256039",
            "is_admin" => true,
        ]);
        $user_2->assignRole("account-officer");
        $user_3 = User::query()->create([
            "firstname" => "Ms. Cashier",
            "lastname" => "Cashier",
            "password" =>bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" =>"cashier@gmail.com",
            "gender" => "female",
            "contact_number" => "09975388638",
            "is_admin" => true,
        ]);
        $user_3->assignRole("cashier");
        $user_4 = User::query()->create([
            "firstname" => "Balayan",
            "lastname" => "Manager",
            "password" => bcrypt("password"),
            "branch_id" => 1,
            "email_verified_at" => null,
            "email" => "balayan.manager@gmail.com",
            "gender" => "female",
            "contact_number" => "09154977001",
            "is_admin" => true,
        ]);
        $user_4->assignRole("branch-manager");
    }
}
