<?php

namespace AIGenerate\Services\Exceptions;

use AIGenerate\Services\Exceptions\Loggers\Contracts\ExceptionServiceContract;
use AIGenerate\Services\Exceptions\Loggers\Contracts\Loggable;
use Throwable;

class ExceptionService implements ExceptionServiceContract
{

    public function __construct(protected Loggable $logger) {}

    public function log(Throwable $throwable, array $options = []): void
    {
        $this->logger->log($throwable);
    }

}
