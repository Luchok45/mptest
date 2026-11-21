<?php

namespace App\Http\Requests\Events;

use App\Enums\RewardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddWinnerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'member_id' => 'required|integer|exists:event_members,id',
            'reward_type' => ['required', 'string', Rule::enum(RewardType::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
