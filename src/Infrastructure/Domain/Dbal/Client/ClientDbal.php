<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 10.12.17
 * Time: 16:39
 */

namespace App\Infrastructure\Domain\Dbal\Client;

use App\Application\Query\View\Client\ClientView;
use App\Domain\Client\Exception\ClientNotFoundException;
use App\Domain\Ports\Db\Dbal\ClientStore;
use App\Infrastructure\DbalRepositoryAbstract;
use Ramsey\Uuid\UuidInterface;

class ClientDbal extends DbalRepositoryAbstract implements ClientStore
{
    public function getById(UuidInterface $id): ClientView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'id',
                'name',
                'password',
                'email'
            )
            ->from('client')
        ->where('id = :id')
        ->setParameter('id', $id);

        $clientData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new ClientView(
            $clientData['id'],
            $clientData['name'],
            $clientData['password'],
            $clientData['email']
        );
    }

    public function getAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'id',
                'name',
                'password',
                'email'
            )
            ->from('client');

        $clientData = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return array_map(function (array $clientData) {
            new ClientView(
                $clientData['id'],
                $clientData['name'],
                $clientData['password'],
                $clientData['email']
            );
        }, $clientData);
    }

    public function getByClientName(string $name): ClientView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'id',
                'name',
                'password',
                'email'
            )
            ->from('client')
            ->where('name = :name')
            ->setParameter('name', $name);

        $clientData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        if ($clientData === null || !isset($clientData) || empty($clientData)) {
            throw new ClientNotFoundException();
        }

        return new ClientView(
            $clientData['id'],
            $clientData['name'],
            $clientData['password'],
            $clientData['email']
        );
    }
}