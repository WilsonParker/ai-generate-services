<?php

namespace AIGenerate\Services\Brevo;

use Brevo\Client\Api\ContactsApi;
use Brevo\Client\Model\CreateContact;
use Brevo\Client\Model\CreateUpdateContactModel;
use Brevo\Client\Model\UpdateContact;
use AIGenerate\Services\Brevo\Contracts\BrevoContract;

class BrevoService implements BrevoContract
{
    public function __construct(
        private readonly ContactsApi $instance
    )
    {
    }

    public function createContact(string $email, array $attributes = [], array $listIds = [11]): CreateUpdateContactModel
    {
        return $this->instance->createContact(
            new CreateContact(
                [
                    'email' => $email,
                    'listIds' => $listIds,
                    'attributes' => [
                        'nickname' => $attributes['nickname'],
                        'generates' => $attributes['generates'],
                        'uuid' => $attributes['uuid'],
                    ]
                ]
            )
        );
    }

    public function updateContact(string $identifier, array $attributes = [], array $listIds = [11]): void
    {
        $this->instance->updateContact(
            $identifier,
            new UpdateContact(
                [
                    'listIds' => $listIds,
                    'attributes' => [
                        'nickname' => $attributes['nickname'],
                        'generates' => $attributes['generates'],
                        'uuid' => $attributes['uuid'],
                    ]
                ]
            )
        );
    }

}
