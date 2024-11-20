<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trainee>
 */
class TraineeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->name(),
            'lastName' => $this->faker->name(),
            'email' => preg_replace('/@example\..*/', '@jothisoftware.com', $this->faker->unique()->safeEmail),
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['guest', 'manager', 'admin'])
        ];
    }
}
