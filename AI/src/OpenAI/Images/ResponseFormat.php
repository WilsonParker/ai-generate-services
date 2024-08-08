<?php

namespace AIGenerate\Services\AI\OpenAI\Images;

enum ResponseFormat: string
{
    case URL = 'url';
    case B64_JSON = 'b64_json';
}
