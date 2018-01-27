<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:27
 */

namespace Hank\Infrastructure\Domain\Repository;

use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\BankAccount\Exception\BankAccountNotFoundException;
use Hank\Infrastructure\DoctrineRepositoryAbstract;
use Hank\Infrastructure\RepositoryInterface;

class BankAccountRepository extends DoctrineRepositoryAbstract implements RepositoryInterface
{
    public function add(object $bankAccount): void
    {
        $this->entityManager->persist($bankAccount);
        $this->entityManager->flush();
    }

    public function getById(string $id): object
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
        $this->entityManager->flush();
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