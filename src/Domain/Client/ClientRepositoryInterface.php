<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:47
 */

namespace App\Domain\Client;

use Ramsey\Uuid\UuidInterface;

interface ClientRepositoryInterface
{
    public function add(Client $client): void;

    public function remove(Client $object): void;

    public function contains(Client $client): bool;

    public function commit(): void;

    public function getById(UuidInterface $id): Client;

    public function getAll(): array;
}