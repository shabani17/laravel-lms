<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],

        'video' => [
            'nullable',
            'file',
            'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska',
            'max:102400',
        ],

        'order' => ['nullable', 'integer', 'min:1'],
        'is_free' => ['nullable', 'boolean'],
        'duration' => ['nullable', 'integer', 'min:0'],
        ];
    }
}