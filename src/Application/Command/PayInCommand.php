<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:13
 */

namespace App\Application\Command;

class PayInCommand
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