<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'level' => $this->level,
            'status' => $this->status,

            'teacher' => [
                'id' => $this->teacher->id,
                'name' => $this->teacher->name,
                'email' => $this->teacher->email,
            ],

            'created_at' => $this->created_at,
        ];
    }
}
