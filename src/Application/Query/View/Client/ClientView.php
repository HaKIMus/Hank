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

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBankAccount(): BankAccountView
    {
        return $this->bankAccount;
    }
}