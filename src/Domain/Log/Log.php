<?php

namespace Hank\Domain\Log;

use Ramsey\Uuid\UuidInterface;

class Log
{
    private $id;
    private $message;
    private $importance;
    private $date;
    private $bankAccount;
    private $client;

    public function __construct(Message $message, Importance $importance, Date $date, UuidInterface $bankAccount, UuidInterface $client)
    {
        $this->message = $message;
        $this->importance = $importance;
        $this->date = $date;
        $this->bankAccount = $bankAccount;
        $this->client = $client;
    }
}