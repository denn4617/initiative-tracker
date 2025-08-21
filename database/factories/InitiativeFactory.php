<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Initiative>
 */
class InitiativeFactory extends Factory
{
    public function definition(): array
    {
        $categories = ['Climate', 'Environment', 'Governance', 'Supply Chain', 'Community'];

        return [
            'title' => fake()->unique()->sentence(3),
            'description' => fake()->paragraph(),
            'impact_score' => fake()->numberBetween(1, 10),
            'category' => fake()->randomElement($categories),
        ];
    }
}
