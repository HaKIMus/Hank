<?php

namespace Hank\Domain\Log;

class Date
{
    private $date;

    public function __construct(
        \DateTime $dateTime
    ) {
        $this->date = $dateTime;
    }

    public function date(): \DateTime
    {
        return $this->date;
    }
}