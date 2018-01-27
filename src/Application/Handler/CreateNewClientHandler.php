<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:26
 */

namespace Hank\Application\Handler;

use Hank\Application\Command\CreateNewClientCommand;
use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Client\Client;
use Hank\Domain\Client\Email;
use Hank\Domain\Client\Name;
use Hank\Domain\Client\Password;
use Hank\Infrastructure\Domain\Repository\ClientRepository;
use Money\Currency;
use Ramsey\Uuid\Uuid;

class CreateNewClientHandler
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function handle(CreateNewClientCommand $command): void
    {
        $bankAccount = new BankAccount(new Balance(
            0.00,
            new Currency('EUR')
        ));

        $client = new Client(
            Uuid::uuid4(),
            new Name($command->getName()),
            new Password($command->getPassword()),
            new Email($command->getEmail()),
            $bankAccount
        );

        $this->clientRepository->add($client);
        $this->clientRepository->commit();
    }
}