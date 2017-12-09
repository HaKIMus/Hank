<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:29
 */

namespace App\Infrastructure;

use Ramsey\Uuid\Uuid;

interface RepositoryInterface
{
    public function add(object $object): void;

    public function getById(Uuid $id): object;

    public function remove(object $object): void;

    public function contains(object $object): bool;
}