<?php

namespace Hank\Domain\Client;

class Name
{
    private $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }
}