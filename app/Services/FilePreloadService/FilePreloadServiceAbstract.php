<?php

namespace App\Services\FilePreloadService;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @method static ?array save(UploadedFile $file, string $save_path = null)
 * @method static ?array saveTo(UploadedFile $file, string $disk = 'storage', string $save_path = 'user_files')
 * @method static BinaryFileResponse downloadPreloadedFile(array $preloaded_file)
 * @method static bool preloadedFileExists(array $preloaded_file)
 */
abstract class FilePreloadServiceAbstract implements FilePreloadServiceInterface
{
    public static function __callStatic(string $name, array $arguments)
    {
        return app(static::class)
            ->$name($arguments);
    }
}
