<?php

namespace Hank\Application\Command;

class PayOutCommand
{
    private $id;
    private $amount;

    public function __construct(string $id, float $amount)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}