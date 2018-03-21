<?php

namespace Hank\Application\Handler;

use Hank\Domain\BankAccount\Balance;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Client\Background;
use Hank\Domain\Client\Client;
use Hank\Domain\Client\Email;
use Hank\Domain\Client\Username;
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

    public function handle(object $command): void
    {
        $bankAccount = new BankAccount(new Balance(
            0.00,
            new Currency('EUR')
        ));

        $client = new Client(
            Uuid::uuid4(),
            new Username($command->getName()),
            new Password($command->getPassword()),
            new Email($command->getEmail()),
            $bankAccount
        );

        $client->setBackground(new Background('http://all4desktop.com/data_images/1680%20x%201050/4167926-os-x-mountain-lion.jpg'));

        $this->clientRepository->add($client);
        $this->clientRepository->commit();
    }
}