<?php

namespace AIGenerate\Services\Generate\Enums;


use AIGenerate\Services\Enums\Traits\GetEnumAttributeTraits;

enum ImageToImageType: string
{
    use GetEnumAttributeTraits;

    case IMAGE_TO_IMAGE = 'image_to_image';
    case STOCK_GENERATE = 'stock_generate';
}
