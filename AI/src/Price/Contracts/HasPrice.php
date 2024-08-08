<?php

namespace AIGenerate\Services\AI\Price\Contracts;

interface HasPrice
{
    public function getInputPrice(): float;

    public function getOutputPrice(): float;
}