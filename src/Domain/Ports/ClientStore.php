<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 03.01.18
 * Time: 06:23
 */

namespace Hank\Domain\Ports;

use Hank\Application\Query\View\Client\ClientView;
use Ramsey\Uuid\UuidInterface;

interface ClientStore
{
    public function getById(UuidInterface $id): ClientView;
    public function getAll(): array;
    public function getByClientName(string $name): ClientView;
}