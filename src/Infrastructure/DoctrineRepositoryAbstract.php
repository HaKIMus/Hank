<?php

namespace Hank\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

abstract class DoctrineRepositoryAbstract
{
    protected $connection;
    protected $entityManager;

    public function __construct(Connection $connection, EntityManagerInterface $entityManager)
    {
        $this->connection = $connection;

        $this->entityManager = $entityManager;
        $this->entityManager->beginTransaction();
    }
}