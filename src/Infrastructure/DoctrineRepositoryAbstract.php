<?php

namespace Hank\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

abstract class DoctrineRepositoryAbstract
{
    protected $connection;
    protected $entityManager;

    public function __construct(Connection $connection, EntityManager $entityManager)
    {
        $this->connection = $connection;

        $this->entityManager = $entityManager;
        $this->entityManager->beginTransaction();
    }
}