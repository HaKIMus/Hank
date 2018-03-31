<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\Client\Email;
use Hank\Domain\Log\Date;
use Hank\Domain\Log\Importance;
use Hank\Domain\Log\Log;
use Hank\Domain\Log\Message;
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
        Ports\SendingMoneyToFriend $sendingMoney,
        LogRepository $log,
        UuidInterface $clientId
    ): void {
        if ($amount < 0) {
            $log->add(
                new Log(
                    new Message('Sending negative amount of money to ' . $email->__toString() . ' denied'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $this->id,
                    $clientId
                )
            );

            $log->commit();

            throw new NegativeAmountOfMoneyException();
        }

        if ($amount === 0.00) {
            $log->add(
                new Log(
                    new Message('Sending no amount of money to ' . $email->__toString() . ' denied'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $this->id,
                    $clientId
                )
            );

            $log->commit();

            throw new NoAmountOfMoneyException();
        }

        if ($amount > $this->balance->getBalance()) {
            $log->add(
                new Log(
                    new Message('Sending ' . $amount . ' amount to ' . $email->__toString() . ' of money which is greater than current balance denied'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $this->id,
                    $clientId
                )
            );

            $log->commit();

            throw new TooLargeAmountOfMoneyException();
        }

        $log->add(
            new Log(
                new Message('Sending ' . $amount . ' amount on money to ' . $email->__toString() . ' done with success'),
                new Importance(1),
                new Date(new \DateTime('now')),
                $this->id,
                $clientId
            )
        );

        $log->commit();

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