<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\Ports;
use Ramsey\Uuid\UuidInterface;

class BankAccount
{
    private $id;
    private $balance;

    public function __construct (
        Balance $balance
    ) {
        $this->balance = $balance;
    }

    public function payIn(Ports\PayIn $accountStore, float $amount, Ports\PayInLogSystem $logSystem): void
    {
        $this->balance->payIn($accountStore, $amount, $logSystem, $this->id);
    }

    public function payOut(float $amountOfMoneyOfMoney, Ports\PayOut $payOut, Ports\PayOutLogSystem $payOutLogSystem): void
    {
        $this->balance->payOut($amountOfMoneyOfMoney, $payOut, $this->id, $payOutLogSystem);
    }

    public function moneyTransfer(): void
    {

    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }
}