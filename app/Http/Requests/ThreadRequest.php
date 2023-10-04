<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'thread_category_id' => ['required', 'exists:thread_categories,id'],
            'title' => ['required', 'string', 'max:100'],
        ];
    }
}
