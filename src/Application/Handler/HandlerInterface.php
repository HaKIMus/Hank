<?php

namespace Hank\Application\Handler;


interface HandlerInterface
{
    public function handle(object $command): void;
}