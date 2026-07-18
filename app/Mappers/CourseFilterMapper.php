<?php

namespace App\Mappers;

use App\DTOs\CourseFilterDTO;
use App\Http\Requests\CourseListRequest;

class CourseFilterMapper
{
    public static function fromRequest(
        CourseListRequest $request
    ): CourseFilterDTO {

        return new CourseFilterDTO(
            search: $request->validated('search'),
            teacherId: $request->validated('teacher'),
            sort: $request->validated('sort'),
            perPage: $request->validated('per_page', 10),
        );
    }
}