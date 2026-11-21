<?php

namespace App\Services\FilePreloadService;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface FilePreloadServiceInterface
{
    public function save(UploadedFile $file, string $save_path = null): ?array;
    public function saveTo(UploadedFile $file, string $disk = 'storage', string $save_path = 'user_files'): ?array;
    public function downloadPreloadedFile(array $preloaded_file): BinaryFileResponse;
    public function preloadedFileExists(array $preloaded_file): bool;
}
