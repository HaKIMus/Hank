<?php

namespace spec\App\Domain\Client\Wallet;

use App\Domain\Client\Wallet\Wallet;
use Money\Currency;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;

class WalletSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Uuid::uuid4(), new Money('30', new Currency('EUR')));

        $this->shouldBeAnInstanceOf(Wallet::class);
    }
}
