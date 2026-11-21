<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class AddReportLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'link' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
