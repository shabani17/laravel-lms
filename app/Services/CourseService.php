<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;

class CourseService
{
    public function create(array $data, User $user): Course
    {
        return Course::create([
            ...$data,
            'teacher_id' => $user->id,
        ]);
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);

        return $course;
    }

    public function delete(Course $course): void
    {
        $course->delete();
    }

    public function teacherCourses(User $user)
    {
        return $user->courses()->latest()->get();
    }

    public function courseStudent(Course $course)
    {
        return $course->students()->get();
    }
}