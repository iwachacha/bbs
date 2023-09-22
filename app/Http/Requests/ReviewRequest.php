<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:50',
            'year' => 'required|string',
            'fulfillment_rate' => 'required|numeric|between:1,5',
            'ease_rate' => 'required|numeric|between:1,5',
            'satisfaction_rate' => 'required|numeric|between:1,5',
            'good_point' => 'nullable|max:500',
            'bad_point' => 'nullable|max:500',
            'lecture_content' => 'nullable|max:500',
        ];
    }
}
