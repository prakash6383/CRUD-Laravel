<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TechStack>
 */
class TechStackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        {
            return [
                'name' => $this->faker->randomElement(['php', 'laravel']),
                'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            ];
        }
    }
}
