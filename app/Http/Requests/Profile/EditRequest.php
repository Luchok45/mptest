<?php

namespace App\Http\Requests\Profile;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //            'birthdate' => ['required', 'date'],
            'phone' => ['required', 'regex:/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/'],
            //            'email' => ['required', 'email', 'max:254'],
        ];
    }

    protected function passedValidation(): void
    {
        //        $this->merge([
        //            'birthdate' => Carbon::parse($this->safe()->input('birthdate'))
        //                ->addHours(3)
        //                ->format('Y-m-d'),
        //        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
