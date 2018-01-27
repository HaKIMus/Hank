<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 20.01.18
 * Time: 15:31
 */

namespace Hank\Infrastructure\Domain\Adapters\LoggingSystem;

use Hank\Domain\Ports\PayInLogSystem;
use Doctrine\DBAL\Connection;

class DbalPayInLogSystemAdapter extends PayInLogSystem
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

        $this->connection->commit();
    }
}