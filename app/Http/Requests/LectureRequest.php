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
            'lecture_category_id' => 'required|exists:lecture_categories,id',
            'season' => ['required', 'string', 'regex:/春学期|秋学期|通年|その他/'],
            'faculty_id' => 'nullable|exists:faculties,id',
            'department_id' => 'nullable|exists:departments,id',
            'course_id' => 'nullable|exists:courses,id',
        ];
    }
}
