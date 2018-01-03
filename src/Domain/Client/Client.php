<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:32
 */

namespace App\Domain\Client;

use App\Domain\Client\BankAccount\BankAccount;
use Ramsey\Uuid\UuidInterface;

class Client
{
    private $id;
    private $name;
    private $password;
    private $email;
    private $bankAccount;

    public function __construct(
        UuidInterface $id,
        Name $name,
        Password $password,
        Email $email,
        BankAccount $bankAccount
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->bankAccount = $bankAccount;
    }
}