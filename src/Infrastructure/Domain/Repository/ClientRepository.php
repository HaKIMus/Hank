<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:27
 */

namespace App\Infrastructure\Domain\Repository;

use App\Domain\Client\Client;
use App\Domain\Client\ClientRepositoryInterface;
use App\Infrastructure\DoctrineRepositoryAbstract;
use Ramsey\Uuid\Uuid;

class ClientRepository extends DoctrineRepositoryAbstract implements ClientRepositoryInterface
{
    public function add(Client $client): void
    {
        $this->entityManager->persist($client);

        $this->entityManager->flush();
    }

    public function getById(Uuid $id): Client
    {
        $client = $this->entityManager->find(Client::class, $id);

        return $client;
    }

    public function remove(Client $client): void
    {
        $this->entityManager->remove($client);
    }

    public function contains(Client $client): bool
    {
        return $this->entityManager->contains($client);
    }
}