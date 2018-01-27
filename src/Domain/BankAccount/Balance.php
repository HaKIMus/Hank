<?php

namespace Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayInLogSystem;
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

    public function payIn(PayIn $accountStore, float $amount, PayInLogSystem $logSystem, UuidInterface $bankAccountId): void
    {
        if ($amount < 0.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amount . ' - it\'s negative amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new NegativeAmountOfMoneyException();
        }

        if ($amount === 0.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amount . ' - it\'s no amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new NoAmountOfMoneyException();
        }

        if ($amount < 5.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amount . ' - it\'s too small amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new TooSmallAmountOfMoneyException();
        }

        if ($amount > 10000.00) {
            $logSystem->setMessageOfLog('Trying to pay in: ' . $amount . ' - it\'s too large amount of money');
            $logSystem->setImportanceOfLog(1);

            $logSystem->log();

            throw new TooLargeAmountOfMoneyException();
        }

        $logSystem->setMessageOfLog('Trying to pay in ' . $amount . ' amount of money done with success');
        $logSystem->setImportanceOfLog(1);

        $logSystem->log();

        $accountStore->payIn($bankAccountId, $amount);
    }
}