<?php

namespace Hank\Domain\Ports;

use Ramsey\Uuid\UuidInterface;

interface PayIn
{
    public function payIn(UuidInterface $walletId, float $amountOfMoney): void;
}