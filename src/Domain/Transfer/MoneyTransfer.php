<?php

namespace App\Domain\Transfer;

use App\Domain\Transfer\Exception\CurrencyNoSupported;
use Money\Money;

final class MoneyTransfer implements TransferInterface
{
    public function transferTo(string $clientId, Money $money): void
    {
        if ($money->getCurrency()->getCode() !== 'EUR') {
            throw new CurrencyNoSupported('Currency ' . $money->getCurrency()->getCode() . ' is not supported!');
        }
    }
}