<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class AddMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
