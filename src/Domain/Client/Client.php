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
    private $name;
    private $password;
    private $email;

    public function __construct(
        string $id,
        Name $name,
        Password $password,
        Email $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
    }
}