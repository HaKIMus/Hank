<?php

namespace spec\Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Ports;
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
        $bankAccountStore->implement(Ports\PayIn::class);
        $logSystem->beADoubleOf(Ports\PayInLogSystem::class);

        $this->payIn($bankAccountStore, 20, $logSystem);
    }

    function it_allows_us_to_pay_out_money($payOutPort, $logSystem): void
    {
        $payOutPort->implement(Ports\PayOut::class);
        $logSystem->beADoubleOf(Ports\LogSystem::class);

        $this->payOut(15, $payOutPort, $logSystem);
    }
}
