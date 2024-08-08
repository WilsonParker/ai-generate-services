<?php

namespace AIGenerate\Services\Exceptions\Facades;

use Illuminate\Support\Facades\Facade;

class ExceptionCodeService extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return \AIGenerate\Services\Exceptions\ExceptionCodeService::class; }
}
