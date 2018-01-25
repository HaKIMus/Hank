<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:27
 */

namespace App\Infrastructure\Domain\Repository;

use App\Domain\BankAccount\BankAccount;
use App\Domain\BankAccount\Exception\BankAccountNotFoundException;
use App\Infrastructure\DoctrineRepositoryAbstract;
use App\Infrastructure\RepositoryInterface;

class BankAccountRepository extends DoctrineRepositoryAbstract implements RepositoryInterface
{
    public function add(object $bankAccount): void
    {
        $this->entityManager->persist($bankAccount);
        $this->entityManager->flush();
    }

    public function getById(object $id): object
    {
        $account = $this->entityManager->getRepository(BankAccount::class)
        ->findOneBy([
            'id' => $id
        ]);

        if ($account === null) {
            throw new BankAccountNotFoundException();
        }

        return $account;
    }

    public function remove(object $bankAccount): void
    {
        $this->entityManager->remove($bankAccount);
    }

    public function contains(object $bankAccount): bool
    {
        return $this->entityManager->contains($bankAccount);
    }

    public function commit(): void
    {
        $this->entityManager->commit();
    }

    public function getAll(): array
    {
        $accounts = $this->entityManager->getRepository(BankAccount::class)
            ->findAll();

        if ($accounts === null) {
            throw new BankAccountNotFoundException();
        }

        return $accounts;
    }
}