<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:27
 */

namespace App\Domain\Ports;

use Ramsey\Uuid\UuidInterface;

interface BankAccountStore
{
    public function payIn(UuidInterface $walletId, float $amount): void;
}