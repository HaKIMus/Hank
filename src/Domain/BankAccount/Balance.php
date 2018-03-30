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

    public function payIn(
        float $amountOfMoney,
        UuidInterface $bankAccountId,
        UuidInterface $clientId,
        Ports\PayIn $payInSystem,
        LogRepository $log
    ): void {
        if ($amountOfMoney < 0.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s negative amount of money'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $bankAccountId,
                    $clientId
                )
            );

            $log->commit();

            throw new NegativeAmountOfMoneyException();
        }

        if ($amountOfMoney === 0.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s no amount of money'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $bankAccountId,
                    $clientId
                )
            );

            $log->commit();

            throw new NoAmountOfMoneyException();
        }

        if ($amountOfMoney < 5.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s too small amount of money'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $bankAccountId,
                    $clientId
                )
            );

            $log->commit();

            throw new TooSmallAmountOfMoneyException();
        }

        if ($amountOfMoney > 10000.00) {
            $log->add(
                new Log(
                    new Message('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s too large amount of money'),
                    new Importance(1),
                    new Date(new \DateTime('now')),
                    $bankAccountId,
                    $clientId
                )
            );

            $log->commit();

            throw new TooLargeAmountOfMoneyException();
        }

        $log->add(
            new Log(
                new Message('Trying to pay in ' . $amountOfMoney . $this->currency . ' amount of money done with success'),
                new Importance(1),
                new Date(new \DateTime('now')),
                $bankAccountId,
                $clientId
            )
        );

        $log->commit();

        $payInSystem->payIn($bankAccountId, $amountOfMoney);
    }

    public function payOut(
        float $amountOfMoney,
        UuidInterface $bankAccountId,
        UuidInterface $clientId,
        Ports\PayOut $payOut,
        LogRepository $log
    ): void {
        if ($amountOfMoney === 0.00) {
            $log->add(
                new Log(
                    new Message('Paying 0out no amount of money denied'),
                    new Importance(2),
                    new Date(new \DateTime('now')),
                    $bankAccountId,
                    $clientId
                )
            );

            $log->commit();

            throw new NoAmountOfMoneyException();
        }

        if (($this->balance - $amountOfMoney) < -100) {
            $log->add(
                new Log(
                    new Message('Paying out ' . $amountOfMoney . $this->currency . ' amount of money denied because the balance after transaction if lower than -100'),
                    new Importance(2),
                    new Date(new \DateTime('now')),
                    $bankAccountId,
                    $clientId
                )
            );

            $log->commit();

            throw new TooLargeAmountOfMoneyException();
        }

        $log->add(
            new Log(
                new Message('Paying out ' . $amountOfMoney . $this->currency . ' done with success'),
                new Importance(1),
                new Date(new \DateTime('now')),
                $bankAccountId,
                $clientId
            )
        );

        $log->commit();

        $payOut->payOut($bankAccountId, $amountOfMoney);
    }
}