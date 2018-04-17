<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Log\Date;
use Hank\Domain\Log\Importance;
use Hank\Domain\Log\Log;
use Hank\Domain\Log\Message;
use Hank\Domain\Ports;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Money\Currency;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Balance
{
    private $balance;
    private $currency;

    public function __construct(float $balance, Currency $currency)
    {
        $this->balance = $balance;
        $this->currency = $currency;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}