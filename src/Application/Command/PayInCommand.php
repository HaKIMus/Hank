<?php

namespace Hank\Application\Command;

class PayInCommand
{
    private $amount;
    private $bankAccountId;
    private $clientId;

    public function __construct(float $amount, string $bankAccountId, string $clientId)
    {
        $this->amount = $amount;
        $this->bankAccountId = $bankAccountId;
        $this->clientId = $clientId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getBankAccountId(): string
    {
        return $this->bankAccountId;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }
}