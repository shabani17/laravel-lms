<?php

namespace App\DTOs;


class CourseFilterDTO
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?int $teacherId = null,
        public readonly ?string $status = null,
        public readonly ?string $level = null,
        public readonly ?string $sort = null,
        public readonly int $perPage = 10,
    ) {
    }

    
}