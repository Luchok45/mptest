<?php

namespace App\Services\FilePreloadService;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StoragePreloadService extends FilePreloadServiceAbstract
{
    protected function defaultFilePath(): string
    {
        return implode(DIRECTORY_SEPARATOR, array_merge([
            'app',
            'user_files',
        ], request()->user() ? [request()->user()->id] : []
        ));
    }

    protected function generateHashedFilename(string $original_filename, string $original_extension): string
    {
        $time = time();

        return sprintf(
            '%d_%s.%s',
            $time,
            hash('md5', "{$time}__{$original_filename}.{$original_extension}"),
            $original_extension
        );
    }

    public function save(UploadedFile $file, ?string $save_path = null): ?array
    {
        return $this->saveTo($file, 'public', $save_path ?? $this->defaultFilePath());
    }

    public function saveTo(UploadedFile $file, string $disk = 'public', string $save_path = 'user_files'): ?array
    {
        $original_filename = $file->getClientOriginalName();
        $original_extension = $file->getClientOriginalExtension();

        $hashed_filename = $this->generateHashedFilename($original_filename, $original_extension);

        $stored_file = Storage::disk($disk)->putFileAs(
            $save_path,
            $file,
            $hashed_filename,
        );

        if (! $stored_file) {
            return null;
        }

        return [
            'disk' => $disk,
            'path' => $save_path,

            'original' => [
                'filename' => $original_filename,
                'extension' => $original_extension,
            ],

            'hashed' => [
                'filename' => $hashed_filename,
                'extension' => $original_extension,
            ],

            'public_link' => $disk === 'public'
                ? Storage::disk($disk)->url($save_path.DIRECTORY_SEPARATOR.$hashed_filename)
                : null,
        ];
    }

    public function downloadPreloadedFile(array $preloaded_file): BinaryFileResponse
    {
        return response()->download(
            Storage::disk($preloaded_file['disk'] ?? 'public')
                ->path($preloaded_file['path'].DIRECTORY_SEPARATOR.$preloaded_file['hashed']['filename']),
            $preloaded_file['original']['filename']
        );
    }

    public function preloadedFileExists(array $preloaded_file): bool
    {
        return Storage::disk($preloaded_file['disk'] ?? 'public')
            ->exists($preloaded_file['path'].DIRECTORY_SEPARATOR.$preloaded_file['hashed']['filename']);
    }
}
