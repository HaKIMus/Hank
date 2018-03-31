<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\Client\Email;
use Hank\Domain\Ports;
use Hank\Infrastructure\Domain\Repository\LogRepository;
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

    public function payIn(
        float $amount,
        UuidInterface $clientId,
        Ports\PayIn $payIn,
        LogRepository $log
    ): void {
        $this->balance->payIn($amount, $this->id, $clientId, $payIn, $log);
    }

    public function payOut(
        float $amount,
        UuidInterface $clientId,
        Ports\PayOut $payOut,
        LogRepository $log
    ): void {
        $this->balance->payOut($amount, $this->id, $clientId, $payOut, $log);
    }

    public function sendMoneyToFriend(
        float $amount,
        Email $email,
        Ports\SendingMoneyToFriend $sendingMoney
    ): void {
        /**
         * @TODO: Logging system
         */

        if ($amount < 0) {
            throw new NegativeAmountOfMoneyException();
        }

        if ($amount === 0.00) {
            throw new NoAmountOfMoneyException();
        }

        if ($amount > $this->balance->getBalance()) {
            throw new TooLargeAmountOfMoneyException();
        }

        $sendingMoney->send($amount, $email, $this->id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getBalance(): float
    {
        return $this->balance->getBalance();
    }

    public function getCurrency(): string
    {
        return $this->balance->getCurrency();
    }
}