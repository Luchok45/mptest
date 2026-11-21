<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class RejectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reject_comment' => 'nullable|string|max:2000',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
