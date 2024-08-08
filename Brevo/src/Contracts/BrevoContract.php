<?php

namespace AIGenerate\Services\Brevo\Contracts;

use Brevo\Client\Model\CreateUpdateContactModel;

interface BrevoContract
{
    public function createContact(string $email, array $attributes = [], array $listIds = [11]): CreateUpdateContactModel;

    public function updateContact(string $identifier, array $attributes = [], array $listIds = [11]): void;
}
