<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LectureRequest extends FormRequest
{
    public function rules()
    {
        return [
            'lecture_name' => 'required|string|max:30',
            'professor_name' => 'required|string|max:30',
            'lecture_category_id' => 'required',
            'season' => 'required|string',
            'faculty_id' => 'nullable',
            'department_id' => 'nullable',
            'course_id' => 'nullable',
        ];
    }
}
