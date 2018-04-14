<?php

namespace Hank\Application\Handler;

use Hank\Application\Command\PayOutCommand;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Ports;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Ramsey\Uuid\Uuid;

class PayOutHandler implements HandlerInterface
{
    private $bankAccountRepository;
    private $payOutPort;
    private $payOutLogSystem;

    public function __construct(BankAccountRepository $bankAccountRepository, Ports\PayOut $payOutPort, LogRepository $logRepository)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->payOutPort = $payOutPort;
        $this->payOutLogSystem = $logRepository;
    }

    /**
     * @param PayOutCommand $command
     */
    public function handle(object $command): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getBankAccountId()));

        $bankAccount->payOut($command->getAmount(), Uuid::fromString($command->getClientId()), $this->payOutPort, $this->payOutLogSystem);
    }
}