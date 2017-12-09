<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:33
 */

namespace App\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

abstract class DoctrineRepositoryAbstract
{
    protected $entityManager;

    public function __construct(Connection $connection, EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}