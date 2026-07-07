<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{

 
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_url',
        'order',
        'is_free',
        'duration',
    ];

    protected function casts(): array
    {
        return [
            'is_free' => 'boolean',
            'duration' => 'integer',
            'order' => 'integer',
        ];
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
