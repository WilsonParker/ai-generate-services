<?php

namespace AIGenerate\Services\AI\OpenAI\Exceptions;

use Exception;

class NotFoundOpenAIStackException extends Exception
{
    protected $message = 'OpenAI key stack not found';

}
