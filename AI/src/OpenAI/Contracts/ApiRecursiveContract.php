<?php

namespace AIGenerate\Services\AI\OpenAI\Contracts;


use AIGenerate\Models\OpenAI\OpenAiKeyStack;

interface ApiRecursiveContract extends ApiContract
{
    public function callApiRecursive(array $attributes, ?OpenAiKeyStack $key = null, ?int $try = 0): array;
}
