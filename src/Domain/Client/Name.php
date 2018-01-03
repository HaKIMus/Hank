<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:32
 */

namespace App\Domain\Client;

class Name
{
    private $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }
}