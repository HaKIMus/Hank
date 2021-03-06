<?php

namespace spec\Hank\Domain\BankAccount;

use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\BankAccount\Exception\NegativeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\NoAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooLargeAmountOfMoneyException;
use Hank\Domain\BankAccount\Exception\TooSmallAmountOfMoneyException;
use Hank\Domain\Client\Email;
use Hank\Domain\Ports;
use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayOut;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Money\Currency;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class BankAccountSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(new Balance( 20.00, new Currency('EUR')));
        $this->setId(Uuid::uuid4());
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BankAccount::class);
    }

    function it_allows_us_to_pay_in_money($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->payIn(20, Uuid::uuid4(), $payInPort, $logSystem);
    }

    function it_throws_exception_when_amount_is_null($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(NoAmountOfMoneyException::class)
            ->during("payIn", [0, Uuid::uuid4(), $payInPort, $logSystem]);
    }


    function it_throws_exception_when_amount_is_negative($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(NegativeAmountOfMoneyException::class)
            ->during("payIn", [-20, Uuid::uuid4(), $payInPort, $logSystem]);
    }

    function it_throws_exception_when_amount_is_smaller_than_5($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(TooSmallAmountOfMoneyException::class)
            ->during("payIn", [4, Uuid::uuid4(), $payInPort, $logSystem]);
    }

    function it_throws_exception_when_amount_is_greater_than_10000($payInPort, $logSystem): void
    {
        $payInPort->implement(PayIn::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(TooLargeAmountOfMoneyException::class)
            ->during("payIn", [10001, Uuid::uuid4(), $payInPort, $logSystem]);
    }

    function it_allows_us_to_pay_out_money($payOutPort, $logSystem): void
    {
        $payOutPort->implement(PayOut::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->payOut(20, Uuid::uuid4(), $payOutPort, $logSystem);
    }

    function it_throws_exception_when_amount_is_null_pay_out_money($payOutPort, $logSystem): void
    {
        $payOutPort->implement(PayOut::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(NoAmountOfMoneyException::class)
            ->during('payOut', [0, Uuid::uuid4(), $payOutPort, $logSystem]);
    }

    function it_throws_exception_when_balance_after_transcation_will_be_less_than_minus_100($payOutPort, $logSystem): void
    {
        $payOutPort->implement(PayOut::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(TooLargeAmountOfMoneyException::class)
            ->during('payOut', [200, Uuid::uuid4(), $payOutPort, $logSystem]);
    }

    function it_allows_us_to_send_money_to_friend($sendingMoneyPort, $logSystem): void
    {
        $sendingMoneyPort->implement(Ports\SendingMoneyToFriend::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->sendMoneyToFriend(20.00, new Email('example@email.com'), $sendingMoneyPort, $logSystem, Uuid::uuid4());
    }

    function it_throws_exception_if_is_sending_amount_greater_than_our_balance($sendingMoneyPort, $logSystem): void
    {
        $sendingMoneyPort->implement(Ports\SendingMoneyToFriend::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(TooLargeAmountOfMoneyException::class)
            ->during('sendMoneyToFriend', [25.00, new Email('example@email.com'), $sendingMoneyPort, $logSystem, Uuid::uuid4()]);
    }

    function it_throws_exception_if_is_sending_negative_amount_of_money($sendingMoneyPort, $logSystem): void
    {
        $sendingMoneyPort->implement(Ports\SendingMoneyToFriend::class);
        $logSystem->beADoubleOf(LogRepository::class);


        $this->shouldThrow(NegativeAmountOfMoneyException::class)
            ->during('sendMoneyToFriend', [-30.00, new Email('example@email.com'), $sendingMoneyPort, $logSystem, Uuid::uuid4()]);
    }

    function it_throws_exception_if_is_sending_no_amount_of_money($sendingMoneyPort, $logSystem): void
    {
        $sendingMoneyPort->implement(Ports\SendingMoneyToFriend::class);
        $logSystem->beADoubleOf(LogRepository::class);

        $this->shouldThrow(NoAmountOfMoneyException::class)
            ->during('sendMoneyToFriend', [00.00, new Email('example@email.com'), $sendingMoneyPort, $logSystem, Uuid::uuid4()]);
    }
}
