<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class AddCoauthorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', 'max:100'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
