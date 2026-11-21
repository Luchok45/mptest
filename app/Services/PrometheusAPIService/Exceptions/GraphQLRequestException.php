<?php

namespace App\Services\PrometheusAPIService\Exceptions;

use Throwable;

class GraphQLRequestException extends RequestException
{
    public function __construct(string $message = '', ?Throwable $previous = null)
    {
        parent::__construct($message, 500, $previous);
    }
}
