<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Ports;
use Money\Currency;
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

    public function payIn(Ports\PayIn $accountStore, float $amountOfMoney, Ports\PayInLogSystem $logSystem, UuidInterface $bankAccountId): void
    {
        if ($amountOfMoney < 0.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s negative amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new NegativeAmountOfMoneyException();
        }

        if ($amountOfMoney === 0.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s no amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new NoAmountOfMoneyException();
        }

        if ($amountOfMoney < 5.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s too small amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new TooSmallAmountOfMoneyException();
        }

        if ($amountOfMoney > 10000.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amountOfMoney . $this->currency . ' - it\'s too large amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new TooLargeAmountOfMoneyException();
        }

        $logSystem->setMessageOfLog('Trying to pay in ' . $amountOfMoney . $this->currency . ' amount of money done with success');
        $logSystem->setImportanceOfLog(1);

        $logSystem->log();

        $accountStore->payIn($bankAccountId, $amountOfMoney);
    }

    public function payOut(float $amountOfMoneyOfMoney, Ports\PayOut $payOut, UuidInterface $bankAccountId, Ports\PayOutLogSystem $payOutLogSystem): void
    {
        if ($amountOfMoneyOfMoney === 0.00) {
            $payOutLogSystem->setImportanceOfLog(1);
            $payOutLogSystem->setMessageOfLog('Paying out no amount of money denied');

            $payOutLogSystem->log();

            throw new NoAmountOfMoneyException();
        }

        if (($this->balance - $amountOfMoneyOfMoney) < -100) {
            $payOutLogSystem->setImportanceOfLog(2);
            $payOutLogSystem->setMessageOfLog('Paying out ' . $amountOfMoneyOfMoney . $this->currency . ' amount of money denied because the balance after transaction if lower than -100');

            $payOutLogSystem->log();

            throw new TooLargeAmountOfMoneyException();
        }

        if ($amountOfMoneyOfMoney > $this->balance) {
            $payOutLogSystem->setImportanceOfLog(1);
            $payOutLogSystem->setMessageOfLog('Paying out ' . $amountOfMoneyOfMoney . $this->currency . ' amount of money which is greater than balance of client: ' . $this->balance);

            $payOutLogSystem->log();
        }

        $payOutLogSystem->setImportanceOfLog(1);
        $payOutLogSystem->setMessageOfLog('Paying out ' . $amountOfMoneyOfMoney . $this->currency . ' done with success');

        $payOutLogSystem->log();

        $payOut->payOut($bankAccountId, $amountOfMoneyOfMoney);
    }
}