<?php

namespace AIGenerate\Services\AI\Price\Composites;

use AIGenerate\Services\AI\OpenAI\Enums\OpenAITypes;
use AIGenerate\Services\AI\Price\Contracts\PriceComposite;

class DallE implements PriceComposite
{

    public function getInputPrice(): float
    {
        // TODO: Implement getInputPrice() method.
    }

    public function getOutputPrice(): float
    {
        // TODO: Implement getOutputPrice() method.
    }

    public function isValid(string $type): bool
    {
        return $type == OpenAITypes::Image;
    }
}