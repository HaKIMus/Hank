<?php

namespace Hank\Domain\Client;

class Password
{
    private $password;

    public function __construct(
        string $password
    ) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}