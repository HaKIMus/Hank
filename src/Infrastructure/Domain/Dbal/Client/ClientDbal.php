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
use App\Infrastructure\DbalRepositoryAbstract;

class ClientDbal extends DbalRepositoryAbstract
{
    public function getById(string $id): ClientView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'id',
                'username',
                'password',
                'email'
            )
            ->from('client')
        ->where('id = :id')
        ->setParameter('id', $id);

        $clientData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new ClientView(
            $clientData['id'],
            $clientData['username'],
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
                'username',
                'password',
                'email'
            )
            ->from('client');

        $clientData = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return array_map(function (array $clientData) {
            new ClientView(
                $clientData['id'],
                $clientData['username'],
                $clientData['password'],
                $clientData['email']
            );
        }, $clientData);
    }

    public function getByUsername(string $username): ClientView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'id',
                'username',
                'password',
                'email'
            )
            ->from('client')
            ->where('username = :username')
            ->setParameter('username', $username);

        $clientData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        if ($clientData === null || !isset($clientData) || empty($clientData)) {
            throw new ClientNotFoundException();
        }

        return new ClientView(
            $clientData['id'],
            $clientData['username'],
            $clientData['password'],
            $clientData['email']
        );
    }
}