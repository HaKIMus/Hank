<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 10.12.17
 * Time: 16:39
 */

namespace Hank\Infrastructure\Domain\Adapters\Db\Dbal;

use Hank\Application\Query\View\BankAccount\BankAccountView;
use Hank\Application\Query\View\Client\ClientView;
use Hank\Domain\Client\Exception\ClientNotFoundException;
use Hank\Domain\Ports\ClientStore;
use Hank\Infrastructure\DbalRepositoryAbstract;
use Ramsey\Uuid\UuidInterface;

class ClientDbalAdapter extends DbalRepositoryAbstract implements ClientStore
{
    public function getById(UuidInterface $id): ClientView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'c.id',
                'c.name',
                'c.password',
                'c.email',
                'c.bankAccountId',
                'ba.id AS bankAccountId',
                'ba.balance',
                'ba.currency'
            )
            ->from('client', 'c')
            ->innerJoin('c', 'bank_account', 'ba','c.bankAccountId = ba.id')
        ->where('c.id = :id')
        ->setParameter('id', $id);

        $clientData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return new ClientView(
            $clientData['id'],
            $clientData['name'],
            $clientData['password'],
            $clientData['email'],
            new BankAccountView(
                $clientData['bankAccountId'],
                $clientData['balance'],
                $clientData['currency']
            )
        );
    }

    public function getAll(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'c.id',
                'c.name',
                'c.password',
                'c.email',
                'c.bankAccountId',
                'ba.id AS bankAccountId',
                'ba.balance',
                'ba.currency'
            )
            ->from('client', 'c')
            ->innerJoin('c', 'bank_account', 'ba','c.bankAccountId = ba.id');

        $clientData = $this->connection->fetchAll($queryBuilder->getSQL(), $queryBuilder->getParameters());

        return array_map(function (array $clientData) {
            new ClientView(
                $clientData['id'],
                $clientData['name'],
                $clientData['password'],
                $clientData['email'],
                new BankAccountView(
                    $clientData['bankAccountId'],
                    $clientData['balance'],
                    $clientData['currency']
                )
            );
        }, $clientData);
    }

    public function getByClientName(string $name): ClientView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select(
                'c.id',
                'c.name',
                'c.password',
                'c.email',
                'c.bankAccountId',
                'ba.id AS bankAccountId',
                'ba.balance',
                'ba.currency'
            )
            ->from('client', 'c')
            ->innerJoin('c', 'bank_account', 'ba','c.bankAccountId = ba.id')
            ->where('c.name = :name')
            ->setParameter('name', $name);

        $clientData = $this->connection->fetchAssoc($queryBuilder->getSQL(), $queryBuilder->getParameters());

        if ($clientData === null || !isset($clientData) || empty($clientData)) {
            throw new ClientNotFoundException();
        }

        return new ClientView(
            $clientData['id'],
            $clientData['name'],
            $clientData['password'],
            $clientData['email'],
            new BankAccountView(
                $clientData['bankAccountId'],
                $clientData['balance'],
                $clientData['currency']
            )
        );
    }
}