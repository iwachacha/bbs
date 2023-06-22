<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'review.title' => 'required|string|max:100',
            'review.lecture_content' => 'required|string|max:300',
            'review.rate_credit' => 'required|integer',
            'review.rate_adequacy' => 'required|integer',
            'review.rate_fun' => 'required|integer',
            'review.year' => 'nullable|integer',
            'review.class_method' => 'nullable|string',
            'review.attedance' => 'nullable|string',
            'review.evaluation_method' => 'nullable|string',
            'review.evaluation_level' => 'nullable|string',
            'review.lecture_level' => 'nullable|string',
            'review.comp_syllabus' => 'nullable|string',
            'review.dtail' => 'nullable|string|max:500'
        ];
    }
}
