<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LectureRequest extends FormRequest
{
    public function rules()
    {
        return [
            'lecture.name' => 'required|string|max:50',
            'lecture.professor_last' => 'required|string|max:50',
            'lecture.professor_first' => 'required|string|max:50',
            'lecture.professor_last' => 'required|string|max:50',
            'lecture.season' => 'required|string',
            'lecture.grade' => 'required|integer'
        ];
    }
}
