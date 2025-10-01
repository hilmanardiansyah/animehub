<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => 1,
            'title' => $this->faker->optional()->words(3, true),
            'synopsis' => $this->faker->optional(0.7)->paragraphs(rand(1, 2), true),
            'aired_at' => $this->faker->optional(0.8)->dateTimeBetween('-10 years', 'now'),
            'duration_sec' => $this->faker->optional(0.9)->numberBetween(1100, 1600),
            'external_official_url' => $this->faker->optional(0.6)->url(),
        ];
    }
}
