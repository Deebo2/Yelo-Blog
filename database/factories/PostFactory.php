<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image' => fake()->imageUrl(),
            'title' => fake()->sentence(),
            'slug' => fake()->slug(3),
            'body' => fake()->paragraph(10),
            'published_at' => fake()->dateTimeBetween('-1 week','+1 week'),
            'featured' => fake()->boolean(10)
        ];
    }
}
