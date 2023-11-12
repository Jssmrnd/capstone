<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Customer::query()->create([
            "firstname" => "Juan",
            "lastname" => "Dela Cruz",
            "middlename" => "M.",
            "gender" => "male",
            "regCode" => "04",
            "provCode" => "0410",
            "citymunCode" => "041034",
            "brgyCode" => "041034018",
            "birthday" => fake()->date(config("app.date_format"), 'now'),
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            "email" => fake()->unique()->safeEmail(),
            "email_verified_at" => now(),
        ]);
        $user->assignRole('customer');
    }
}
