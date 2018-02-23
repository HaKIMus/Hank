<?php

namespace Hank\Infrastructure\Domain\Repository;

use Doctrine\ORM\ORMException;
use Hank\Domain\Log\Exception\LogNotFoundException;
use Hank\Domain\Log\Log;
use Hank\Infrastructure\DoctrineRepositoryAbstract;
use Hank\Infrastructure\RepositoryInterface;

class LogRepository extends DoctrineRepositoryAbstract implements RepositoryInterface
{
    public function add(object $log): void
    {
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

    public function getById(string $id): object
    {
        $log = $this->entityManager->getRepository(Log::class)
        ->findOneBy([
            'id' => $id
        ]);

        if ($log === null) {
            throw new LogNotFoundException();
        }

        return $log;
    }

    public function remove(object $log): void
    {
        $this->entityManager->remove($log);
        $this->entityManager->flush();
    }

    public function contains(object $log): bool
    {
        return $this->entityManager->contains($log);
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function getAll(): array
    {
        $logs = $this->entityManager->getRepository(Log::class)
            ->findAll();

        if ($logs === null) {
            throw new LogNotFoundException();
        }

        return $logs;
    }
}