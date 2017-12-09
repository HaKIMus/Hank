<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:32
 */

namespace App\Domain\Client;

class Password
{
    private $password;

    public function __construct(
        string $password
    ) {
        $this->password = $password;
    }
}