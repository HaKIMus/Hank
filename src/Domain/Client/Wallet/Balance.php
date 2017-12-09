<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 01:01
 */

namespace App\Domain\Client\Wallet;


use Money\Money;

class Balance
{
    private $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function subtract(Money $amount): void
    {

    }
}