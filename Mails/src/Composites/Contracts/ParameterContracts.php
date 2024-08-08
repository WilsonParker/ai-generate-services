<?php

namespace AIGenerate\Services\Mails\Composites\Contracts;

interface ParameterContracts
{
    public function hasParams(array $params): bool;

    public function bindParams(array $params, $data = null): array;

    public function bindParam(string $param, $data = null): string;

    public function getParams(): array;
}