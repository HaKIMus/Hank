<?php

namespace Hank\Application\Command;

use Ramsey\Uuid\UuidInterface;

class SendMoneyToFriendsCommand
{
    private $amount;
    private $email;
    private $bankAccountId;

    public function __construct(float $amount, string $email, string $bankAccountId)
    {
        $this->amount = $amount;
        $this->email = $email;
        $this->bankAccountId = $bankAccountId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBankAccountId(): string
    {
        return $this->bankAccountId;
    }
}