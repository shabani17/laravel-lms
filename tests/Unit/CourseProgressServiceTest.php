<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Services\CourseProgressService;

class CourseProgressServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_progress_is_calculated_correctly()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $lesson1 = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $lesson2 = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        LessonProgress::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson1->id,
            'completed_at' => now(),
        ]);

        $service = new CourseProgressService();

        $result = $service->calculate(
            $user,
            $course
        );

        $this->assertEquals(2, $result->totalLessons);

        $this->assertEquals(1, $result->completedLessons);

        $this->assertEquals(50, $result->percentage);
    }

    public function test_course_progress_returns_zero_when_course_has_no_lessons()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $service = new CourseProgressService();

        $result = $service->calculate(
            $user,
            $course
        );

        $this->assertEquals(0, $result->totalLessons);

        $this->assertEquals(0, $result->completedLessons);

        $this->assertEquals(0, $result->percentage);
    }
}