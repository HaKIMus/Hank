<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 20.01.18
 * Time: 15:29
 */

namespace App\Domain\Ports;

use Ramsey\Uuid\Uuid;

abstract class PayInLogSystem
{
    protected $id;
    protected $dateOfLogOccurred;
    protected $idOfClient;
    protected $idOfBankAccount;
    private $messageOfLog;
    private $importanceOfLog;

    public function __construct(string $idOfBankAccount, string $idOfClient)
    {
        $datetime = new \DateTime();

        $this->id = Uuid::uuid4();
        $this->dateOfLogOccurred = $datetime->format('Y-m-d H:i:s');
        $this->idOfBankAccount = $idOfBankAccount;
        $this->idOfClient = $idOfClient;
    }

    public function setMessageOfLog(string $messageOfLog = 'Error'): void
    {
        $this->messageOfLog = $messageOfLog;
    }

    public function setImportanceOfLog(int $importanceOfLog = 1): void
    {
        $this->importanceOfLog = $importanceOfLog;
    }

    public function getMessageOfLog(): string
    {
        if (!$this->importanceOfLog) {
            throw new \LogicException('The messageOfLog parameter is not declared');
        }

        return $this->messageOfLog;
    }

    public function getImportanceOfLog(): int
    {
        if (!$this->importanceOfLog) {
            throw new \LogicException('The importanceOfLog parameter is not declared');
        }

        return $this->importanceOfLog;
    }

    abstract function log(): void;
}