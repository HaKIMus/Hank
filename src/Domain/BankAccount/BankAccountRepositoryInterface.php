<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:47
 */

namespace App\Domain\BankAccount;

use Ramsey\Uuid\UuidInterface;

interface BankAccountRepositoryInterface
{
    public function add(BankAccount $bankAccount): void;

    public function remove(BankAccount $bankAccount): void;

    public function contains(BankAccount $bankAccount): bool;

    public function commit(): void;

    public function getById(UuidInterface $id): BankAccount;

    public function getAll(): array;
}