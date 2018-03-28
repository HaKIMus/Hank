<?php

namespace Hank\Infrastructure\Service;

use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;

class ChangeBackgroundService
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function change(string $urlToNewBackground, UuidInterface $clientId): void
    {
        $this->translateErrorsToException();

        try {
            $contentType = get_headers($urlToNewBackground, 1)['Content-Type'];
        } catch (\Exception $exception) {
            throw new \Exception('We cannot download the image from this page');
        }

        if (is_array($contentType)) {
            foreach ($contentType as $type) {
                if ($this->isFirstWordLike($type, 'image')) {
                    $contentType = $type;
                    break;
                } else {
                    throw new \InvalidArgumentException('The URL is not a image');
                }
            }
        }

        if (!$this->isFirstWordLike($contentType, 'image')) {
            throw new \InvalidArgumentException('The URL is not a image');
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

    private function translateErrorsToException(): bool
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
            if (0 === error_reporting()) {
                return false;
            }

            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        return true;
    }
}