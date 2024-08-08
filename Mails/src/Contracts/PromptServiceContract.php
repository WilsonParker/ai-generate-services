<?php

namespace AIGenerate\Services\Mails\Contracts;

use Illuminate\Support\Collection;

interface PromptServiceContract
{
    public function getBestPrompts(): Collection;
}