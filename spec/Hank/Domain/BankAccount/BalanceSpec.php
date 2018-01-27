<?php

namespace spec\Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayInLogSystem;
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

    function it_allows_us_to_pay_in_money($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->payIn($payInPort, 20, $logSystem, Uuid::uuid4());
    }

    function it_throws_exception_when_amount_is_null($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(NoAmountOfMoneyException::class)
            ->during("payIn", [$payInPort, 0, $logSystem, Uuid::uuid4()]);
    }


    function it_throws_exception_when_amount_is_negative($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(NegativeAmountOfMoneyException::class)
            ->during("payIn", [$payInPort, -20, $logSystem, Uuid::uuid4()]);
    }

    function it_throws_exception_when_amount_is_smaller_than_5($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(TooSmallAmountOfMoneyException::class)
            ->during("payIn", [$payInPort, 4, $logSystem, Uuid::uuid4()]);
    }

    function it_throws_exception_when_amount_is_greater_than_10000($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(PayInLogSystem::class);

        $this->shouldThrow(TooLargeAmountOfMoneyException::class)
            ->during("payIn", [$payInPort, 10001, $logSystem, Uuid::uuid4()]);
    }

    function it_allows_us_to_pay_out_money($payOutPort): void
    {
        $payOutPort->implement(PayOut::class);

        $this->payOut(20, $payOutPort);
    }
}
