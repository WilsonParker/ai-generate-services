<?php

namespace AIGenerate\Services\Mails\Contracts;

use AIGenerate\Services\Mails\Model\Contracts\Receiver;
use AIGenerate\Services\Mails\Model\Contracts\Sender;
use AIGenerate\Services\Mails\Model\Contracts\Template;
use Illuminate\Support\Collection;

interface MailContract
{
    function send(Template $template, Sender $from, Receiver $to, UserMailable $mailable);

    function getTemplates(): Collection;
    function getTemplate(string $id): Template;

    function getLog(string $id);
}