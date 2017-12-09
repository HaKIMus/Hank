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

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}