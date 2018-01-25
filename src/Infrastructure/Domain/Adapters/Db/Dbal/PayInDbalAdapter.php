<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 21:38
 */

namespace App\Infrastructure\Domain\Adapters\Db\Dbal;


use App\Infrastructure\DbalRepositoryAbstract;
use App\Domain\Ports\PayIn;
use Ramsey\Uuid\UuidInterface;

class PayInDbalAdapter extends DbalRepositoryAbstract implements PayIn
{
    public function payIn(UuidInterface $walletId, float $amount): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->update('bank_account')
            ->set('balance', 'balance + :amount')
            ->where('id = :id')
            ->setParameter('amount', $amount)
            ->setParameter('id', $walletId);

        $queryBuilder->execute();
    }
}