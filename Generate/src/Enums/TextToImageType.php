<?php

namespace AIGenerate\Services\Generate\Enums;

use AIGenerate\Services\Enums\Traits\GetEnumAttributeTraits;

enum TextToImageType: string
{
    use GetEnumAttributeTraits;

    case TEXT_TO_IMAGE  = 'text_to_image';
    case TEXT_GENERATE  = 'text_generate';
    case FIGMA_GENERATE = 'figma_generate';
}
