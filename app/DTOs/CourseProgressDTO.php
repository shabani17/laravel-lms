<?php

namespace App\DTOs;

class CourseProgressDTO
{
    public function __construct(
        public readonly int $totalLessons,
        public readonly int $completedLessons,
        public readonly float $percentage,
    ) {}
}