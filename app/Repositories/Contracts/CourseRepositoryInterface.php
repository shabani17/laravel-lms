<?php

namespace App\Repositories\Contracts;

use App\DTOs\CourseFilterDTO;
use App\Models\Course;
use Illuminate\Pagination\LengthAwarePaginator;

interface CourseRepositoryInterface
{
    public function list(CourseFilterDTO $filters): LengthAwarePaginator;

    public function find(Course $course): Course;

    public function create(array $data): Course;

    public function update(Course $course, array $data): Course;

    public function delete(Course $course): void;
}