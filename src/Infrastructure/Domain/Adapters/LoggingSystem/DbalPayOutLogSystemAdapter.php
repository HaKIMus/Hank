<?php

namespace Hank\Infrastructure\Domain\Adapters\LoggingSystem;

use Doctrine\DBAL\Connection;
use Hank\Domain\Ports\PayOutLogSystem;

class DbalPayOutLogSystemAdapter extends PayOutLogSystem
{
    private $connection;

    public function __construct(string $idOfBankAccount, string $idOfClient, Connection $connection)
    {
        parent::__construct($idOfBankAccount, $idOfClient);

        $this->connection = $connection;
    }

    public function log(): void
    {
        $this->connection->insert('logs', [
            'id' => $this->id,
            'bankAccountId' => $this->idOfBankAccount,
            'clientId' => $this->idOfClient,
            'message' => $this->getMessageOfLog(),
            'importance' => $this->getImportanceOfLog(),
            'date' => $this->dateOfLogOccurred
        ]);
    }
}