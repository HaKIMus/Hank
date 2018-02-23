<?php

namespace Hank\Application\Command;

class PayOutCommand
{
    private $bankAccountId;
    private $amount;
    private $clientId;

    public function __construct(float $amount, string $bankAccountId, string $clientId)
    {
        $this->bankAccountId = $bankAccountId;
        $this->amount = $amount;
        $this->clientId = $clientId;
    }

    public function getBankAccountId(): string
    {
        return $this->bankAccountId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }
}