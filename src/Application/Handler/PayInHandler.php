<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:26
 */

namespace App\Application\Handler;

use App\Application\Command\PayInCommand;

use App\Domain\Ports\PayIn;
use App\Domain\Ports\PayInLogSystem;
use App\Infrastructure\Domain\Repository\BankAccountRepository;
use Ramsey\Uuid\Uuid;

class PayInHandler
{
    private $bankAccountRepository;
    private $bankAccountStore;
    private $payInLogSystem;

    public function __construct(BankAccountRepository $bankAccountRepository, PayIn $bankAccountStore, PayInLogSystem $payInLogSystem)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankAccountStore = $bankAccountStore;
        $this->payInLogSystem = $payInLogSystem;
    }

    public function handle(PayInCommand $command): void
    {
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getId()));

        $bankAccount->payIn($this->bankAccountStore, $command->getAmount(), $this->payInLogSystem);
    }
}