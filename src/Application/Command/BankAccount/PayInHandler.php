<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:26
 */

namespace App\Application\Command\BankAccount;

use App\Domain\Client\BankAccount\BankAccountRepositoryInterface;
use App\Domain\Ports\BankAccountStore;
use App\Infrastructure\Domain\Adapters\Db\Dbal\BankAccountDbalAdapter;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;

class PayInHandler
{
    private $bankAccountRepository;
    private $bankAccountStore;

    public function __construct(BankAccountRepositoryInterface $bankAccountRepository, BankAccountStore $bankAccountStore)
    {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankAccountStore = $bankAccountStore;
    }

    public function handle(PayInCommand $command)
    {
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getId()));

        $bankAccount->payIn($this->bankAccountStore, $command->getAmount());
        $this->bankAccountRepository->commit();
    }
}