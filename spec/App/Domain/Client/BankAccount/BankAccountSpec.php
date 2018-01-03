<?php

namespace spec\App\Domain\Client\BankAccount;

use App\Domain\Client\BankAccount\Balance;
use App\Domain\Client\BankAccount\BankAccount;
use App\Domain\Client\BankAccount\Exception\NegativeAmountOfMoneyException;
use App\Domain\Client\BankAccount\Exception\NoAmountOfMoneyException;
use App\Domain\Client\BankAccount\Exception\TooLargeAmountOfMoneyException;
use App\Domain\Client\BankAccount\Exception\TooSmallAmountOfMoneyException;
use App\Domain\Ports\BankAccountStore;
use App\Infrastructure\Domain\Adapters\Db\Dbal\BankAccountDbalAdapter;
use Doctrine\DBAL\Connection;
use Money\Currency;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class BankAccountSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Uuid::uuid4(), new Balance( 20, new Currency('EUR')));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BankAccount::class);
    }

    function it_allows_us_to_pay_in_money($bankAccountStore)
    {
        $bankAccountStore->implement(BankAccountStore::class);

        $this->payIn($bankAccountStore, 20);
    }

    function it_throws_exception_when_amount_is_null($bankAccountStore)
    {
        $bankAccountStore->implement(BankAccountStore::class);

        $this->shouldThrow(NoAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, 0]);
    }


    function it_throws_exception_when_amount_is_negative($bankAccountStore)
    {
        $bankAccountStore->implement(BankAccountStore::class);

        $this->shouldThrow(NegativeAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, -20]);
    }

    function it_throws_exception_when_amount_is_smaller_than_5($bankAccountStore)
    {
        $bankAccountStore->implement(BankAccountStore::class);

        $this->shouldThrow(TooSmallAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, 4]);
    }

    function it_throws_exception_when_amount_is_greater_than_10000($bankAccountStore)
    {
        $bankAccountStore->implement(BankAccountStore::class);

        $this->shouldThrow(TooLargeAmountOfMoneyException::class)
            ->during("payIn", [$bankAccountStore, 10001]);
    }
}
