<?php

namespace Hank\Infrastructure;

interface RepositoryInterface
{
    public function add(object $object): void;

    public function getById(string $id): object;

    public function getAll(): array;

    public function remove(object $object): void;

    public function contains(object $object): bool;

    public function commit(): void;
}