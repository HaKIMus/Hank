<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:27
 */

namespace Hank\Domain\Ports;

use Ramsey\Uuid\UuidInterface;

interface PayIn
{
    public function payIn(UuidInterface $walletId, float $amount): void;
}