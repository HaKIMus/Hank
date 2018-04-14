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

    public function __toString(): string
    {
        return $this->email;
    }
}