<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'review.title' => 'required|string|max:50',
            'review.year' => 'required|integer',
            'review.class_method' => 'required|string',
            'review.attedance' => 'required|string',
            'review.evaluation_method' => 'required|string',
            'review.evaluation_level' => 'required|string',
            'review.lecture_level' => 'required|string',
            'review.comp_syllabus' => 'required|string',
            'review.lecture_content' => 'required|string',
            'review.body' => 'required|string',
            'review.rate_credit' => 'required|integer',
            'review.rate_adequacy' => 'required|integer',
            'review.rate_satisfaction' => 'required|integer'
        ];
    }
}
