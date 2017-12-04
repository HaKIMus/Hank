<?php

namespace App\Domain\Transfer;


use Money\Money;

interface TransferInterface
{
    public function transferTo(string $clientId, Money $money): void;
}