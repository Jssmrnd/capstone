<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // public function configure(): static
    // {
    //     return $this->afterMaking(function (User $user) {
    //         return $user->assignRole('branch-manager');
    //     });
    // }

    public function definition(): array
    {
        return [
            'name' => "",
            'is_admin' => true,
            'email' => fake()->unique()->safeEmail(),
            'gender' => fake()->randomElement(['male','female']),
            'branch_id' => 7,
            'contact_number' => fake()->randomDigit(11),
            'birthday' => fake()->date('Y-m-d', 'now'),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
