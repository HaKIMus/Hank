<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 10.12.17
 * Time: 16:43
 */

namespace App\Application\Query\View\Client;


use App\Application\Query\View\BankAccount\BankAccountView;

class ClientView
{
    private $id;
    private $name;
    private $password;
    private $email;
    private $bankAccount;

    public function __construct(
        string $id,
        string $name,
        string $password,
        string $email,
        BankAccountView $bankAccount
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->bankAccount = $bankAccount;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function getBankAccount(): BankAccountView
    {
        return $this->bankAccount;
    }
}