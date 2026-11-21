<?php

namespace App\Http\Requests;

use App\Services\FilePreloadService\FilePreloadServiceInterface;
use Illuminate\Foundation\Http\FormRequest;

class PreloadImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'image', 'mimes:jpeg,png,jpg'],
        ];
    }

    public function saveFile(?string $save_path = null): ?array
    {
        return app(FilePreloadServiceInterface::class)
            ->save($this->file('file'), $save_path);
    }

    public function authorize(): bool
    {
        return true;
    }
}
