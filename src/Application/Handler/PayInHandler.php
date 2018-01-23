<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:26
 */

namespace App\Application\Handler;

use App\Application\Command\PayInCommand;
use App\Domain\BankAccount\BankAccountRepositoryInterface;
use App\Domain\Ports\BankAccountStore;
use App\Domain\Ports\PayInLogSystem;
use Ramsey\Uuid\Uuid;

class PayInHandler
{
    private $bankAccountRepository;
    private $bankAccountStore;
    private $payInLogSystem;

    public function __construct(BankAccountRepositoryInterface $bankAccountRepository, BankAccountStore $bankAccountStore, PayInLogSystem $payInLogSystem)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankAccountStore = $bankAccountStore;
        $this->payInLogSystem = $payInLogSystem;
    }

    public function handle(PayInCommand $command)
    {
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getId()));

        $bankAccount->payIn($this->bankAccountStore, $command->getAmount(), $this->payInLogSystem);
    }
}