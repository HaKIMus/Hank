<?php

namespace spec\App\Domain\Transfer;

use App\Domain\Transfer\MoneyTransfer;
use Money\Currency;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MoneyTransferSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(MoneyTransfer::class);
    }

    function it_transfer_money_to_another_account($money): void
    {
        $money = new Money(20, new Currency('EUR'));

        $this->transferTo('HaKIM', $money);
    }

    function it_should_not_allow_to_transfer_money_if_currency_is_not_in_euro()
    {
        $money = new Money(20, new Currency('PLN'));

        $this->shouldThrow('App\Domain\Transfer\Exception\CurrencyNoSupported')
            ->during('transferTo', ['HaKIM', $money]);
    }
}
