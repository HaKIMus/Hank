<?php

namespace Hank\Application\Handler;

use Hank\Application\Command\PayInCommand;

use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayInLogSystem;
use Hank\Domain\Ports\PayOut;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Ramsey\Uuid\Uuid;

class PayOutHandler implements HandlerInterface
{
    private $bankAccountRepository;
    private $payOutPort;

    public function __construct(BankAccountRepository $bankAccountRepository, PayOut $payOutPort)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->payOutPort = $payOutPort;
    }

    public function handle(object $command): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getId()));

        $bankAccount->payOut($command->getAmount(), $this->payOutPort);

        $this->bankAccountRepository->commit();
    }
}