<?php

namespace Hank\Application\Handler;

use Hank\Application\Command\PayInCommand;

use Hank\Domain\Ports\PayIn;
use Hank\Domain\Ports\PayInLogSystem;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Ramsey\Uuid\Uuid;

class PayInHandler
{
    private $bankAccountRepository;
    private $payInPort;
    private $payInLogSystem;

    public function __construct(BankAccountRepository $bankAccountRepository, PayIn $payInPort, PayInLogSystem $payInLogSystem)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->payInPort = $payInPort;
        $this->payInLogSystem = $payInLogSystem;
    }

    public function handle(object $command): void
    {
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getId()));

        $bankAccount->payIn($this->payInPort, $command->getAmount(), $this->payInLogSystem);
    }
}