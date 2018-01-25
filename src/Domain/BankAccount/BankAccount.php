<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:41
 */

namespace App\Domain\BankAccount;

use App\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use App\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use App\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use App\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use App\Domain\Ports\PayIn;
use App\Domain\Ports\PayInLogSystem;
use Ramsey\Uuid\UuidInterface;

final class BankAccount
{
    private $id;
    private $accountOwner;
    private $balance;

    public function __construct (
        UuidInterface $accountOwner,
        Balance $balance
    ) {
        $this->accountOwner = $accountOwner;
        $this->balance = $balance;
    }

    public function payIn(PayIn $accountStore, float $amount, PayInLogSystem $logSystem): void
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

        $accountStore->payIn($this->id, $amount);
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