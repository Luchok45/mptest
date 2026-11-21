<?php

namespace App\Services\PrometheusAPIService\DTO\Responses\Directories;

readonly class DirectoriesListResponse
{
    public function __construct(
        /** @var iterable<DirectoriesListItem> $items */
        public iterable $items
    ) {}

    public static function fromJson(array $json): DirectoriesListResponse
    {
        return new self(
            array_map(fn ($item) => DirectoriesListItem::fromJson($item), $json),
        );
    }
}
