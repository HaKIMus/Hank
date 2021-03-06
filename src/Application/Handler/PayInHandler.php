<?php

namespace Hank\Application\Handler;

use Hank\Application\Command\PayInCommand;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Ports\PayIn;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Ramsey\Uuid\Uuid;

class PayInHandler implements HandlerInterface
{
    private $bankAccountRepository;
    private $payInPort;
    private $payInLogSystem;

    public function __construct(
        BankAccountRepository $bankAccountRepository,
        PayIn $payInPort,
        LogRepository $logRepository
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->payInPort = $payInPort;
        $this->payInLogSystem = $logRepository;
    }

    /**
     * @param PayInCommand $command
     */
    public function handle(object $command): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getBankAccountId()));

        $bankAccount->payIn($command->getAmount(), Uuid::fromString($command->getClientId()), $this->payInPort, $this->payInLogSystem);
    }
}