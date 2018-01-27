<?php

namespace spec\Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayInLogSystem;
use Money\Currency;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class BankAccountSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(new Balance( 20, new Currency('EUR')));
        $this->setId(Uuid::uuid4());
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BankAccount::class);
    }

    function it_allows_us_to_pay_in_money($bankAccountStore, $logSystem): void
    {
        $bankAccountStore->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->payIn($bankAccountStore, 20, $logSystem);
    }
}
