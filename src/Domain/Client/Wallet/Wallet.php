<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:41
 */

namespace App\Domain\Client\Wallet;

use Money\Money;

class Wallet
{
    private $ownerId;

    public function __construct(
        string $ownerId,
        Money $balance
    ) {
        $this->ownerId = $ownerId;
    }

    public function payIn(): void
    {
    }

    public function payOut(): Money
    {

    }

    private function balance(): Balance
    {

    }
}