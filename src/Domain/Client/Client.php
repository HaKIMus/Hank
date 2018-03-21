<?php

namespace Hank\Domain\Client;

use Hank\Domain\BankAccount\BankAccount;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Client implements UserInterface, \Serializable
{
    private $id;
    private $username;
    private $password;
    private $email;
    private $bankAccount;
    private $background;

    public function __construct(
        UuidInterface $id,
        Username $username,
        Password $password,
        Email $email,
        BankAccount $bankAccount
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->bankAccount = $bankAccount;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getBankAccount(): BankAccount
    {
        return $this->bankAccount;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function serialize(): ?string
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->bankAccount,
            $this->background
        ]);
    }

    public function unserialize($serialized): void
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->bankAccount,
            $this->background
            ) = unserialize($serialized);
    }

    public function setBackground(Background $background): void
    {
        $this->background = $background;
    }

    public function getBackground(): string
    {
        return $this->background;
    }
}