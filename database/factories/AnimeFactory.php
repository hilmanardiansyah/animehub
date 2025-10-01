<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anime>
 */
class AnimeFactory extends Factory
{

    public function definition(): array
    {
        $title = $this->faker->unique()->words(rand(2,4), true);
        return [
            'title' => Str::title($title),
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'synopsis' => $this->faker->paragraphs(rand(2,4), true),
            'poster_path' => null,
            'banner_path' => null,
            'status' => $this->faker->randomElement(['ongoing','completed','hiatus']),
            'type' => $this->faker->randomElement(['tv','movie','ova','ona','special']),
            'aired_at' => $this->faker->optional(0.8)->dateTimeBetween('-10 years','now'),
            'rating_avg' => null,
            'popularity' => $this->faker->numberBetween(0, 500000),
        ];
    }
}
