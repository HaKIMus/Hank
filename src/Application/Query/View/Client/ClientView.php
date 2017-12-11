<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 10.12.17
 * Time: 16:43
 */

namespace App\Application\Query\View\Client;


class ClientView
{
    private $id;
    private $username;
    private $password;
    private $email;

    public function __construct(
        string $id,
        string $username,
        string $password,
        string $email
    ) {

        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}