<?php

namespace spec\App\Domain\BankAccount;

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
    function let()
    {
        $this->beConstructedWith(new Balance( 20, new Currency('EUR')));
        $this->setId(Uuid::uuid4());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BankAccount::class);
    }

    function it_allows_us_to_pay_in_money($bankAccountStore, $logSystem)
    {
        $bankAccountStore->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->payIn($bankAccountStore, 20, $logSystem);
    }

    function it_throws_exception_when_amount_is_null($bankAccountStore, $logSystem)
    {
        $bankAccountStore->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(NoAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, 0, $logSystem]);
    }


    function it_throws_exception_when_amount_is_negative($bankAccountStore, $logSystem)
    {
        $bankAccountStore->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(NegativeAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, -20, $logSystem]);
    }

    function it_throws_exception_when_amount_is_smaller_than_5($bankAccountStore, $logSystem)
    {
        $bankAccountStore->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(TooSmallAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, 4, $logSystem]);
    }

    function it_throws_exception_when_amount_is_greater_than_10000($bankAccountStore, $logSystem)
    {
        $bankAccountStore->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(TooLargeAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, 10001, $logSystem]);
    }
}
