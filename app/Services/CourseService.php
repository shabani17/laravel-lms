<?php

namespace App\Services;

use App\DTOs\CourseFilterDTO;
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

    public function list(CourseFilterDTO $filters)
    {
        $query = Course::query();
        $query->with('teacher');

        $query->when($filters->search, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });

        $query->when($filters->teacherId, function ($query, $teacherId) {
            $query->where('teacher_id', $teacherId);
        });

        return $query->paginate($filters->perPage);
    }
}