<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:29
 */

namespace App\Infrastructure;

interface RepositoryInterface
{
    public function add(object $object): void;

    public function getById(object $id): object;

    public function getAll(): array;

    public function remove(object $object): void;

    public function contains(object $object): bool;

    public function commit(): void;
}