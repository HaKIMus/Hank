<?php

namespace spec\App\Domain\Client\BankAccount;

use App\Domain\Client\BankAccount\Balance;
use App\Domain\Client\BankAccount\BankAccount;
use Money\Currency;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class BankAccountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Uuid::uuid4(), new Balance( 20, new Currency('EUR')));
        $this->shouldHaveType(BankAccount::class);
    }

    function it_allows_us_to_pay_in_money()
    {

    }
}
