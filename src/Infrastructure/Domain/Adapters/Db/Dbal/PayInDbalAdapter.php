<?php

namespace Hank\Infrastructure\Domain\Adapters\Db\Dbal;


use Hank\Infrastructure\DbalRepositoryAbstract;
use Hank\Domain\Ports\PayIn;
use Ramsey\Uuid\UuidInterface;

class PayInDbalAdapter extends DbalRepositoryAbstract implements PayIn
{
    public function payIn(UuidInterface $walletId, float $amountOfMoney): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->update('bank_account')
            ->set('balance', 'balance + :amount')
            ->where('id = :id')
            ->setParameter('amount', $amountOfMoney)
            ->setParameter('id', $walletId);

        $queryBuilder->execute();
    }
}