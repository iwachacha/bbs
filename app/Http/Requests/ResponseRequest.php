<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'body' => ['required', 'string', 'max:500'],
            'reply_id' => ['nullable', 'exists:responses,id']
        ];
    }
}
