<?php

namespace Hank\Domain\Client;

class Email
{
    private $email;

    public function __construct(
        string $email
    ) {
        $this->email = $email;
    }
}