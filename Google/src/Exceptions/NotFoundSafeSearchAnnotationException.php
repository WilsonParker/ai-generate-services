<?php

namespace AIGenerate\Services\Google\Exceptions;

use Exception;

class NotFoundSafeSearchAnnotationException extends Exception
{
    protected $message = 'Not found safeSearchAnnotation';
}