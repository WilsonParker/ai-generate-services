<?php

namespace AIGenerate\Services\AI\OpenAI\Contracts;


interface Request
{
    public function rules(): array;

    public function commonRules(): array;
}
