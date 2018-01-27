<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 01.01.18
 * Time: 09:53
 */

namespace Hank\Domain\BankAccount;

use Money\Currency;

class Balance
{
    private $balance;
    private $currency;

    public function __construct(float $balance, Currency $currency)
    {
        $this->balance = $balance;
        $this->currency = $currency;
    }
}