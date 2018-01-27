<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 08.12.17
 * Time: 00:32
 */

namespace Hank\Domain\Client;

class Email
{
    private $email;

    public function __construct(
        string $email
    ) {
        $this->email = $email;
    }
}