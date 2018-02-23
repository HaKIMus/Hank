<?php

namespace spec\Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Ports;
use Hank\Infrastructure\Domain\Repository\LogRepository;
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

    function it_allows_us_to_pay_in_money($payInPort, $logSystem): void
    {
        $payInPort->implement(Ports\PayIn::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->payIn(20, Uuid::uuid4(), $payInPort, $logSystem);
    }

    function it_allows_us_to_pay_out_money($payOutPort, $logSystem): void
    {
        $payOutPort->implement(Ports\PayOut::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->payOut(20, Uuid::uuid4(), $payOutPort, $logSystem);
    }
}
