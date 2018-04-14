<?php

namespace Hank\Domain\Ports;

use Hank\Domain\Client\Email;
use Ramsey\Uuid\UuidInterface;

interface SendingMoneyToFriend
{
    public function send(float $amount, Email $email, UuidInterface $bankAccountId): void;
}