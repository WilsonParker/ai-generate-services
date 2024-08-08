<?php

namespace AIGenerate\Services\Mails\Model\Contracts;

interface Sender
{
    public function getId(): int;

    public function getName(): string;

    public function getEmail(): string;


}