<?php

namespace AIGenerate\Services\Exceptions\Loggers;

use AIGenerate\Services\Exceptions\Facades\ExceptionCodeService;
use AIGenerate\Services\Exceptions\Loggers\Contracts\Loggable;
use Throwable;

class DatabaseLogger implements Loggable
{
    public function __construct(protected string $model) {}

    public function log(Throwable $throwable, array $options = []): void
    {
        $this->model::create([
            'message' => $throwable->getMessage(),
            'code' => $options['code'] ?? ExceptionCodeService::getCode($throwable),
            'file' => $options['file'] ?? $throwable->getFile(),
            'trace' => $options['trace'] ?? $throwable->getTraceAsString(),
        ]);
    }
}
