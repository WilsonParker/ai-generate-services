<?php

namespace AIGenerate\Services\Mails\Composites\Parameters;

use AIGenerate\Services\Mails\Composites\Contracts\ParameterContracts;
use Illuminate\Support\Arr;

abstract class BaseParameters implements ParameterContracts
{

    public function hasParams(array $params): bool
    {
        return Arr::first($params, fn($param) => in_array($param, $this->getParams())) != null;
    }

}