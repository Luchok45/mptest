<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class PreloadedFileRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $disk = $value['disk'] ?? 'storage';
        $path = $value['path'] ?? '';
        $filename = $value['hashed']['filename'] ?? null;

        if (! Storage::disk($disk)->fileExists($path.DIRECTORY_SEPARATOR.$filename)) {
            $fail('validation.preloaded_file')->translate();
        }
    }
}
