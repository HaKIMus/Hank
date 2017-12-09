<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:32
 */

namespace App\Domain\Client;

class Username
{
    private $username;

    public function __construct(
        string $username
    ) {
        $this->username = $username;
    }
}