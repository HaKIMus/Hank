<?php

namespace Hank\Domain\Log;

class Importance
{
    private $importance;

    public function __construct(
        int $importance
    ) {
        $this->importance = $importance;
    }

    public function importance(): int
    {
        return $this->importance;
    }
}