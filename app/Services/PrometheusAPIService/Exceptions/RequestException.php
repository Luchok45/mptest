<?php

namespace App\Services\PrometheusAPIService\Exceptions;

use Throwable;

class RequestException extends PrometheusAPIException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
