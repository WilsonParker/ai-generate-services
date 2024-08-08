<?php

namespace AIGenerate\Services\Mails;

use Illuminate\Support\Collection;
use AIGenerate\Services\Mails\Contracts\MailContract;
use AIGenerate\Services\Mails\Contracts\UserMailable;
use AIGenerate\Services\Mails\Model\Contracts\Receiver;
use AIGenerate\Services\Mails\Model\Contracts\Sender;
use AIGenerate\Services\Mails\Model\Contracts\Template;

class MailService
{
    public function __construct(private readonly MailContract $contract) {}

    public function getTemplates(): Collection
    {
        return $this->contract->getTemplates();
    }

    public function getTemplate(string $id): Template
    {
        return $this->contract->getTemplate($id);
    }

    public function send(Template $template, Sender $from, Receiver $to, UserMailable $mailable)
    {
        $this->contract->send($template, $from, $to, $mailable);
    }

    public function getLog(string $id)
    {
        return $this->contract->getLog($id);
    }

    public function getParams(string $content): array
    {
        return $this->contract->getParams($content);
    }
}