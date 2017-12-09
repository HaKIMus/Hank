<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:33
 */

namespace App\Infrastructure;

use Doctrine\DBAL\Connection;

abstract class DbalRepositoryAbstract
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}