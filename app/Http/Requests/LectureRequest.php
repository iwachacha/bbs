<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LectureRequest extends FormRequest
{
    public function rules()
    {
        return [
            'lecture.lecture_name' => 'required|string|max:50',
            'lecture.professor_name' => 'required|string|max:50|regex:/^[^0-9０-９]+$/u',
            'lecture.season' => 'required|string',
            'lecture.grade' => 'required|integer',
            'lecture.lecture_category_id' => 'required|integer|regex:/[1-5]/',
        ];
    }
}
