<?php

namespace Hank\Application\Query\View\BankAccount;


class BankAccountView
{
    private $id;
    private $balance;
    private $currency;

    public function __construct(
        string $id,
        float $balance,
        string $currency
    ) {
        $this->id = $id;
        $this->balance = $balance;
        $this->currency = $currency;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function balance(): float
    {
        return $this->balance;
    }

    public function currency(): string
    {
        return $this->currency;
    }
}