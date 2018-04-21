<?php

namespace spec\Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayOut;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Money\Currency;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class BalanceSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(20, new Currency('EUR'));
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Balance::class);
    }
}
