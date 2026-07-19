<?php

namespace App\Repositories\Contracts;

use App\DTOs\CourseFilterDTO;
use App\Models\Course;

interface CourseRepositoryInterface
{
    public function list(CourseFilterDTO $filters);

    public function find(Course $course): Course;

    public function create(array $data): Course;

    public function update(Course $course, array $data): Course;

    public function delete(Course $course): void;
}