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
    private $name;
    private $password;
    private $email;

    public function __construct(
        string $id,
        string $name,
        string $password,
        string $email
    ) {

        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
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
}