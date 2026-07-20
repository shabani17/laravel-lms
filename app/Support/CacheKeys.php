<?php

namespace App\Support;

use App\DTOs\CourseFilterDTO;

class CacheKeys
{
    public static function courses(CourseFilterDTO $filters): string
    {
        return sprintf(
            'courses:search=%s:teacher=%s:level=%s:status=%s:sort=%s:per_page=%d',
            $filters->search ?? 'all',
            $filters->teacherId ?? 'all',
            $filters->level ?? 'all',
            $filters->status ?? 'all',
            $filters->sort ?? 'latest',
            $filters->perPage
        );
    }
}