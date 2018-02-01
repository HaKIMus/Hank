<?php

namespace Hank\Application\Handler;

use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Ports;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Ramsey\Uuid\Uuid;

class PayOutHandler implements HandlerInterface
{
    private $bankAccountRepository;
    private $payOutPort;
    private $payOutLogSystem;

    public function __construct(BankAccountRepository $bankAccountRepository, Ports\PayOut $payOutPort, Ports\PayOutLogSystem $payOutLogSystem)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->payOutPort = $payOutPort;
        $this->payOutLogSystem = $payOutLogSystem;
    }

    public function handle(object $command): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getId()));

        $bankAccount->payOut($command->getAmount(), $this->payOutPort, $this->payOutLogSystem);

        $this->bankAccountRepository->commit();
    }
}