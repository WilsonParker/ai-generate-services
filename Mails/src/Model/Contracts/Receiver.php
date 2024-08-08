<?php

namespace AIGenerate\Services\Mails\Model\Contracts;

interface Receiver
{

    public function getName(): string;

    public function getEmail(): string;


}