<?php

namespace Hank\Infrastructure\Domain\Adapters\Db\Dbal;

use Hank\Domain\Client\Email;
use Hank\Domain\Ports\SendingMoneyToFriend;
use Hank\Infrastructure\DbalRepositoryAbstract;
use Ramsey\Uuid\UuidInterface;

class SendingMoneyToFriendAdapter extends DbalRepositoryAbstract implements SendingMoneyToFriend
{
    public function send(float $amount, Email $email, UuidInterface $bankAccountId): void {
        $queryBuilder = $this->connection->createQueryBuilder();

        $email = $email->__toString();

        /**
         * @see I haven't used the DBAL's queryBuilder because of this issue: ttps://github.com/doctrine/dbal/issues/2716
         */
        $query = "UPDATE bank_account AS b 
                  INNER JOIN client AS c ON c.bankAccountId = b.id 
                  SET b.balance = b.balance + :amount
                  WHERE c.email = :email";

        $preparedQuery = $this->connection->prepare($query);

        $preparedQuery->bindParam(':amount', $amount);
        $preparedQuery->bindParam(':email', $email);

        $queryBuilder->update('bank_account')
            ->set('balance', 'balance - :amount')
            ->where('id = :id')
            ->setParameter('amount', $amount)
            ->setParameter('id', $bankAccountId);

        $queryBuilder->execute();
        $preparedQuery->execute();
    }
}