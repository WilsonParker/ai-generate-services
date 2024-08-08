<?php

namespace AIGenerate\Services\Mails\Contracts;

use Illuminate\Support\Collection;

interface MailParameterContract
{
    public function bindParams(Collection $params, UserMailable $mailable): array;
}