<?php

namespace AIGenerate\Services\Google\Exceptions;

use Exception;

class TokenNotFoundException extends Exception
{
    protected $message = 'Token not found';
}