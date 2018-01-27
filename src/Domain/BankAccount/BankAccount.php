<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayInLogSystem;
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

    public function payIn(PayIn $accountStore, float $amount, PayInLogSystem $logSystem): void
    {
        $this->balance->payIn($accountStore, $amount, $logSystem, $this->id);
    }

    public function payOut(): void
    {

    }

    public function moneyTransfer(): void
    {

    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }
}