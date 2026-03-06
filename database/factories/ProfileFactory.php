<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'name' => $this->faker->name(),
            'bio' => $this->faker->paragraph(),
            'likes_count' => $this->faker->numberBetween(0, 1000),
            'last_scraped_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
