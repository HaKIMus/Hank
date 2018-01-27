<?php

namespace Hank\Domain\Ports;

use Ramsey\Uuid\UuidInterface;

interface PayOut
{
    public function payOut(UuidInterface $walletId, int $amountOfMoney): void;
}