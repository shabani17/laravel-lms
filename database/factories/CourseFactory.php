<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),

            'slug' => fake()->unique()->slug(),

            'description' => fake()->paragraph(),

            'price' => fake()->randomFloat(2, 0, 1000),

            'thumbnail' => null,

            'level' => fake()->randomElement([
                'beginner',
                'intermediate',
                'advanced',
            ]),

            'status' => 'published',

            'published_at' => now(),
        ];
    }
}