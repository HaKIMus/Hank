<?php

namespace Hank\Application\Command;


class CreateNewClientCommand
{
    private $name;
    private $password;
    private $email;

    public function __construct(
        string $name,
        string $password,
        string $email
    ) {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}