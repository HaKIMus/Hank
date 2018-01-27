<?php

namespace Hank\Infrastructure;

use Doctrine\DBAL\Connection;

abstract class DbalRepositoryAbstract
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}