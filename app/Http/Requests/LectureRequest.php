<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LectureRequest extends FormRequest
{
    public function rules()
    {
        return [
            'lecture.lecture_name' => 'required|string|max:100',
            'lecture.professor_name' => 'required|string|max:100',
            'lecture.season' => 'required|string',
            'lecture.grade' => 'required|integer'
        ];
    }
}
