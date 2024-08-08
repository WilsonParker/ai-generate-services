<?php

namespace AIGenerate\Services\Mails\Contracts;

interface UserMailable
{
    public function getName(): string;
    public function getMyPageLink(): string;
}