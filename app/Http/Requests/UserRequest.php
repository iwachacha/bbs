<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50', 'unique:'.User::class],
            'email' => ['required', 'regex:/[a-z][0-9][ehl][1-4][1-9a][0-9]{3}@bunkyo\.ac\.jp/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'grade' => ['nullable', 'regex:/1年|2年|3年|4年|その他/'],
            'faculty_id' => ['nullable', 'exists:faculties,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
        ];
    }

    public function messages()
    {
        return [
            'email.regex' => '大学配布のメールアドレスを入力してください。',
        ];
    }
}
