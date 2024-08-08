<?php

namespace AIGenerate\Services\Exceptions\Loggers\Contracts;

use Throwable;

interface ExceptionServiceContract
{
    public function log(Throwable $throwable, array $options = []): void;

}
