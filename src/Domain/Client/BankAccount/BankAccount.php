<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:41
 */

namespace App\Domain\Client\BankAccount;

use App\Domain\Client\BankAccount\Exception\NegativeAmountOfMoneyException;
use App\Domain\Client\BankAccount\Exception\NoAmountOfMoneyException;
use App\Domain\Client\BankAccount\Exception\TooLargeAmountOfMoneyException;
use App\Domain\Client\BankAccount\Exception\TooSmallAmountOfMoneyException;
use App\Domain\Ports\BankAccountStore;
use Ramsey\Uuid\UuidInterface;

class BankAccount
{
    private $id;
    private $accountOwner;
    private $balance;

    public function __construct(
        UuidInterface $accountOwner,
        Balance $balance
    ) {
        $this->accountOwner = $accountOwner;
        $this->balance = $balance;
    }

    public function payIn(BankAccountStore $accountStore, float $amount): void
    {
        if ($amount < 0.00) {
            throw new NegativeAmountOfMoneyException();
        }

        if ($amount === 0.00) {
            throw new NoAmountOfMoneyException();
        }

        if ($amount < 5.00) {
            throw new TooSmallAmountOfMoneyException();
        }

        if ($amount > 10000.00) {
            throw new TooLargeAmountOfMoneyException();
        }

        $accountStore->payIn($this->accountOwner, $amount);
    }

    public function payOut(): void
    {

    }

    public function moneyTransfer(): void
    {

    }
}
