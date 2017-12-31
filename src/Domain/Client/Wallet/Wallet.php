<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:41
 */

namespace App\Domain\Client\Wallet;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

class Wallet
{
    private $ownerId;

    public function __construct(
        UuidInterface $ownerId,
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
