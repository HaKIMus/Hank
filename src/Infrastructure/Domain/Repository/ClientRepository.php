<?php

namespace Hank\Infrastructure\Domain\Repository;

use Hank\Domain\Client\Client;
use Hank\Domain\Client\Exception\ClientNotFoundException;
use Hank\Infrastructure\DoctrineRepositoryAbstract;
use Hank\Infrastructure\RepositoryInterface;

class ClientRepository extends DoctrineRepositoryAbstract implements RepositoryInterface
{
    public function add(object $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    public function getById(string $id): object
    {
        $client = $this->entityManager->getRepository(Client::class)
        ->findOneBy([
            'id' => $id
        ]);

        if ($client === null) {
            throw new ClientNotFoundException();
        }

        return $client;
    }

    public function remove(object $client): void
    {
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }

    public function contains(object $client): bool
    {
        return $this->entityManager->contains($client);
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function getAll(): array
    {
        $clients = $this->entityManager->getRepository(Client::class)
            ->findAll();

        if ($clients === null) {
            throw new ClientNotFoundException();
        }

        return $clients;
    }
}