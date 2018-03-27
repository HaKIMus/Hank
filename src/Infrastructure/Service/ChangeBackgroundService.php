<?php

namespace Hank\Infrastructure\Service;

use Doctrine\DBAL\Connection;

class ChangeBackgroundService
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function change(string $urlToNewBackground, string $clientId): void
    {
        $contentType = get_headers($urlToNewBackground, 1)['Content-Type'];

        if (!$this->isFirstWordLike($contentType, 'image')) {
            throw new \InvalidArgumentException('The URL is not image');
        }

        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->update('client')
            ->set('background', ':newBackground')
            ->where('id = :id')
            ->setParameter('newBackground', $urlToNewBackground)
            ->setParameter('id', $clientId);

        $queryBuilder->execute();
    }

    private function isFirstWordLike(string $sentence, string $word): bool
    {
        if (strtok($sentence, "/") === $word) {
            return true;
        }

        return false;
    }
}