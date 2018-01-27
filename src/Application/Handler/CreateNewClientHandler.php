<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:26
 */

namespace App\Application\Handler;

use App\Application\Command\CreateNewClientCommand;
use App\Domain\BankAccount\Balance;
use App\Domain\BankAccount\BankAccount;
use App\Domain\Client\Client;
use App\Domain\Client\Email;
use App\Domain\Client\Name;
use App\Domain\Client\Password;
use App\Infrastructure\Domain\Repository\ClientRepository;
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