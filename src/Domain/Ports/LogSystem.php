<?php

namespace Hank\Domain\Ports;

interface LogSystem
{
    public function log(): void;
}