<?php

namespace Hank\Infrastructure\Domain\Adapters\Db\Dbal;

use Hank\Domain\Ports\PayOut;
use Hank\Infrastructure\DbalRepositoryAbstract;
use Ramsey\Uuid\UuidInterface;

class PayOutDbalAdapter extends DbalRepositoryAbstract implements PayOut
{
    public function payOut(UuidInterface $walletId, float $amountOfMoney): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->update('bank_account')
            ->set('balance', 'balance - :amount')
            ->where('id = :id')
            ->setParameter('amount', $amountOfMoney)
            ->setParameter('id', $walletId);

        $queryBuilder->execute();
    }
}