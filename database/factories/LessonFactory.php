<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),

            'title' => fake()->sentence(),

            'description' => fake()->paragraph(),

            'video_url' => 'https://example.com/video.mp4',

            'order' => fake()->numberBetween(1, 10),

            'is_free' => fake()->boolean(),

            'duration' => fake()->numberBetween(10, 120),
        ];
    }
}