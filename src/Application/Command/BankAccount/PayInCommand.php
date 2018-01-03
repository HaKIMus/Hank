<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 07:13
 */

namespace App\Application\Command\BankAccount;


use Ramsey\Uuid\UuidInterface;

class PayInCommand
{
    private $id;
    private $amount;

    public function __construct(UuidInterface $id, float $amount)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}