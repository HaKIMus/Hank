<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:41
 */

namespace App\Domain\Client\BankAccount;

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

    public function payIn(): void
    {

    }

    public function payOut(): void
    {

    }

    public function moneyTransfer(): void
    {

    }
}
