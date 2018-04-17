<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
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
        float $amountOfMoney,
        UuidInterface $clientId,
        Ports\PayIn $payInSystem,
        LogRepository $log
    ): void {
        if ($amountOfMoney < 0.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->balance->getCurrency() . ' - it\'s negative amount of money'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $this->id,
                    $clientId
                )
            );

            $log->commit();

            throw new NegativeAmountOfMoneyException();
        }

        if ($amountOfMoney === 0.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->balance->getCurrency() . ' - it\'s no amount of money'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $this->id,
                    $clientId
                )
            );

            $log->commit();

            throw new NoAmountOfMoneyException();
        }

        if ($amountOfMoney < 5.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->balance->getCurrency() . ' - it\'s too small amount of money'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $this->id,
                    $clientId
                )
            );

            $log->commit();

            throw new TooSmallAmountOfMoneyException();
        }

        if ($amountOfMoney > 10000.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->balance->getCurrency() . ' - it\'s too large amount of money'),
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
                new Message('Trying to pay in ' . $amountOfMoney . $this->balance->getCurrency() . ' amount of money done with success'),
                new Importance(1),
                new Date(new \DateTime('now')),
                $this->id,
                $clientId
            )
        );

        $log->commit();

        $payInSystem->payIn($this->id, $amountOfMoney);
    }

    public function payOut(
        float $amountOfMoney,
        UuidInterface $clientId,
        Ports\PayOut $payOut,
        LogRepository $log
    ): void {
        if ($amountOfMoney === 0.00) {
            $log->add(
                new Log(
                    new Message('Paying out no amount of money denied'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $this->id,
                    $clientId
                )
            );

            $log->commit();

            throw new NoAmountOfMoneyException();
        }

        if (($this->getBalance() - $amountOfMoney) < -100.00) {
            $log->add(
                new Log(
                    new Message('Paying out ' . $amountOfMoney . $this->balance->getCurrency() . ' amount of money denied because the balance after transaction if lower than -100'),
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
                new Message('Paying out ' . $amountOfMoney . $this->balance->getCurrency() . ' done with success'),
                new Importance(1),
                new Date(new \DateTime('now')),
                $this->id,
                $clientId
            )
        );

        $log->commit();

        $payOut->payOut($this->id, $amountOfMoney);
    }
    
    public function sendMoneyToFriend(
        float $amount,
        Email $email,
        Ports\SendingMoneyToFriend $sendingMoney,
        LogRepository $log,
        UuidInterface $clientId
    ): void {
        if ($amount < 0.00) {
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

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
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