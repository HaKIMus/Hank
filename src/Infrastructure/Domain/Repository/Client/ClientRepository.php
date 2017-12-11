<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:27
 */

namespace App\Infrastructure\Domain\Repository\Client;

use App\Domain\Client\Client;
use App\Domain\Client\ClientRepositoryInterface;
use App\Domain\Client\Exception\ClientNotFoundException;
use App\Infrastructure\DoctrineRepositoryAbstract;
use Doctrine\ORM\OptimisticLockException;
use Ramsey\Uuid\Uuid;

class ClientRepository extends DoctrineRepositoryAbstract implements ClientRepositoryInterface
{
    public function add(Client $client): void
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }

    public function getById(Uuid $id): Client
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

    public function remove(Client $client): void
    {
        $this->entityManager->remove($client);
    }

    public function contains(Client $client): bool
    {
        return $this->entityManager->contains($client);
    }
}