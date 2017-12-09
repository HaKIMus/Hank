<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:32
 */

namespace App\Domain\Client;

class Client
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
}