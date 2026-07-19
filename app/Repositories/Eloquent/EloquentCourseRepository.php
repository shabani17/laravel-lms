<?php

namespace App\Repositories\Eloquent;

use App\DTOs\CourseFilterDTO;
use App\Models\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;

class EloquentCourseRepository implements CourseRepositoryInterface
{
    public function list(CourseFilterDTO $filters)
    {
        $query = Course::query();

        $query->with('teacher');

        $query->when($filters->search, function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        });

        $query->when($filters->teacherId, function ($query, $teacherId) {
            $query->where('teacher_id', $teacherId);
        });

        $query->when($filters->status, function ($query, $status) {
            $query->where('status', $status);
        });

        $query->when($filters->level, function ($query, $level) {
            $query->where('level', $level);
        });

        $query->when($filters->sort, function ($query, $sort) {
            match ($sort) {
                'latest' => $query->latest(),
                'price_high' => $query->orderByDesc('price'),
                'price_low' => $query->orderBy('price'),
                default => null,
            };
        });

        return $query->paginate($filters->perPage);
    }

    public function find(Course $course): Course
    {
        return $course;
    }

    public function create(array $data): Course
    {
        return Course::create($data);
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
}