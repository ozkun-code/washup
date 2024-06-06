<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'price' => fake()->numberBetween(10000, 100000),
            'description' => fake()->sentence(),
            'estimated_completion_time' => fake()->randomElement(['1 day', '2 days', '3 days', '4 days', '5 days']),    
            //
        ];
    }
}
