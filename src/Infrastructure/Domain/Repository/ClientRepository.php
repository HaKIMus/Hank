<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:27
 */

namespace App\Infrastructure\Domain\Repository;

use App\Domain\Client\Client;
use App\Domain\Client\Exception\ClientNotFoundException;
use App\Infrastructure\DoctrineRepositoryAbstract;
use App\Infrastructure\RepositoryInterface;

class ClientRepository extends DoctrineRepositoryAbstract implements RepositoryInterface
{
    public function add(object $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    public function getById(object $id): object
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