<?php

namespace Hank\Domain\Log;

class Message
{
    private $message;

    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }

    public function message(): string
    {
        return $this->message;
    }
}