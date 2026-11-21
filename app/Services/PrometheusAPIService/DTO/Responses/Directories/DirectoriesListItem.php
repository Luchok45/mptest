<?php

namespace App\Services\PrometheusAPIService\DTO\Responses\Directories;

readonly class DirectoriesListItem
{
    public function __construct(
        public int $id,
        public string $name,
        public string $model,
    ) {}

    public static function fromJson(array $json): DirectoriesListItem
    {
        return new self(
            $json['id'],
            $json['name'],
            $json['model'],
        );
    }
}
