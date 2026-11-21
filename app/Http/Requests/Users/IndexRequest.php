<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:200',
            'search' => 'nullable|string|max:255',
            'filters' => 'nullable|array',
            'filters.role' => ['nullable', 'string', Rule::exists('roles', 'name')->where('guard_name', 'web')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
