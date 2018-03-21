<?php

namespace Hank\Domain\Client;

class Background
{
    private $background;

    public function __construct(string $background)
    {
        $this->background = $background;
    }

    public function __toString(): string
    {
        return $this->background;
    }
}