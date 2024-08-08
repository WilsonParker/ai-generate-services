<?php

namespace AIGenerate\Services\AI\Price;


use AIGenerate\Services\AI\Price\Contracts\HasPrice;

class PromptPriceService
{
    /**
     * @var array<\AIGenerate\Services\AI\Price\Contracts\HasPrice> $composites
     */
    public function __construct(
        private readonly array $composites,
    ) {}

    /**
     * @throws \AIGenerate\Services\AI\Price\Exceptions\InvalidPriceTypeException
     */
    public function getPrice(string $type): HasPrice
    {
        foreach ($this->composites as $composite) {
            if ($composite->isValid($type)) {
                return $composite;
            }
        }
        throw new Exceptions\InvalidPriceTypeException();
    }
}