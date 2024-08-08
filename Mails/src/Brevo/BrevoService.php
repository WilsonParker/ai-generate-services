<?php

namespace AIGenerate\Services\Mails\Brevo;

use Brevo\Client\Api\ConversationsApi;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\GetSmtpTemplateOverview;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use AIGenerate\Services\Mails\Contracts\MailContract;
use AIGenerate\Services\Mails\Contracts\UserMailable;
use AIGenerate\Services\Mails\MaiParameterComposite;
use AIGenerate\Services\Mails\Model\Contracts\Receiver;
use AIGenerate\Services\Mails\Model\Contracts\Sender;
use AIGenerate\Services\Mails\Model\Contracts\Template;

class BrevoService implements MailContract
{
    private $transactionalEmailsApi;
    private $conversationApi;

    public function __construct(
        private readonly string                $apiKey,
        private readonly MaiParameterComposite $composite
    )
    {
        // Configure API key authorization: api-key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);

        $this->transactionalEmailsApi = new TransactionalEmailsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );

        $this->conversationApi = new ConversationsApi(
        // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        // This is optional, `GuzzleHttp\Client` will be used as default.
            new Client(),
            $config
        );
    }

    public function send(Template $template, Sender $from, Receiver $to, UserMailable $mailable)
    {
        $params = $this->composite->bindParams($this->getParams($template->getHtmlContent()), [
            'user' => $mailable,
        ]);
        $sendSmtpEmail = new SendSmtpEmail(
            [
                'sender' => [
                    'name' => $from->getName(),
                    'email' => $from->getEmail(),
                ],
                'to' => [
                    [
                        'email' => $to->getEmail(),
                        'name' => $to->getName(),
                    ],
                ],
                'templateId' => $template->getId(),
                'params' => $params['params'] ?? null,
            ]
        );
        $sendSmtpEmail = $this->transactionalEmailsApi->sendTransacEmail($sendSmtpEmail);
    }

    public function getParams(string $content): array
    {
        $pattern = '/\{\{(params.*?)\}\}/';
        preg_match_all($pattern, $content, $matches);
        return collect($matches[1])->unique()->filter()->toArray();
    }

    public function getTemplates(): Collection
    {
        return collect($this->transactionalEmailsApi->getSmtpTemplates()->getTemplates())
            ->map(fn(GetSmtpTemplateOverview $template) => new \AIGenerate\Services\Mails\Model\Template([
                'id' => $template->getId(),
                'name' => $template->getName(),
                'subject' => $template->getSubject(),
                'is_active' => $template->getIsActive(),
                'test_sent' => $template->getTestSent(),
                'sender' => $template->getSender(),
                'reply_to' => $template->getReplyTo(),
                'to_field' => $template->getToField(),
                'tag' => $template->getTag(),
                'html_content' => $template->getHtmlContent(),
                'created_at' => $template->getCreatedAt(),
                'updated_at' => $template->getModifiedAt(),
            ]));
    }

    public function getLog(string $id)
    {
        return $this->conversationApi->conversationsMessagesIdGet($id);
    }

    public function getTemplate(string $id): Template
    {
        $template = $this->transactionalEmailsApi->getSmtpTemplate($id);
        return new \AIGenerate\Services\Mails\Model\Template([
            'id' => $template->getId(),
            'name' => $template->getName(),
            'subject' => $template->getSubject(),
            'is_active' => $template->getIsActive(),
            'test_sent' => $template->getTestSent(),
            'sender' => $template->getSender(),
            'reply_to' => $template->getReplyTo(),
            'to_field' => $template->getToField(),
            'tag' => $template->getTag(),
            'html_content' => $template->getHtmlContent(),
            'created_at' => $template->getCreatedAt(),
            'updated_at' => $template->getModifiedAt(),
        ]);
    }
}
