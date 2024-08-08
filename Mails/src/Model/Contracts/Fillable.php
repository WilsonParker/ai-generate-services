<?php

namespace AIGenerate\Services\Mails\Model\Contracts;

interface Fillable
{

    function fill(array $attributes): static;

    function fillableFromArray(array $attributes);

    function getFillable(): array;
}