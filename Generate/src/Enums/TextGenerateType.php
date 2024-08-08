<?php

namespace AIGenerate\Services\Generate\Enums;

use AIGenerate\Services\Enums\Traits\GetEnumAttributeTraits;

enum TextGenerateType: string
{
    use GetEnumAttributeTraits;

    case Portrait = 'portrait';
    case Animal   = 'animal';
    case Object   = 'object';
}
