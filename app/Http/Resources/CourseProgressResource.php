<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseProgressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_lessons' => $this->totalLessons,
            'completed_lessons' => $this->completedLessons,
            'progress_percentage' => $this->percentage,
        ];
    }
}