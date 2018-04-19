<?php

namespace Hank\Domain\Client;

class Avatar
{
    private $avatar;

    public function __construct(string $avatar)
    {
        $this->avatar = $avatar;
    }

    public function __toString(): string
    {
        return $this->avatar;
    }
}