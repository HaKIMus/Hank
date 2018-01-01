<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:47
 */

namespace App\Domain\Client;

use Ramsey\Uuid\Uuid;

interface ClientStore
{
    public function add(Client $client): void;

    public function getById(Uuid $id): Client;

    public function getAll(): array;

    public function remove(Client $object): void;
}