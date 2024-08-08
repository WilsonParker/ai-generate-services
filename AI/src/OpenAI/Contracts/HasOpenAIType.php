<?php

namespace AIGenerate\Services\AI\OpenAI\Contracts;

use AIGenerate\Services\AI\OpenAI\Enums\OpenAITypes;

interface HasOpenAIType
{
    public function getOpenAIType(): OpenAITypes;
}