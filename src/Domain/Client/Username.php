<?php

namespace Hank\Domain\Client;

class Username
{
    private $username;

    public function __construct(
        string $username
    ) {
        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }
}