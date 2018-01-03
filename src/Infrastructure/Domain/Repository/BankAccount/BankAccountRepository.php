<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 09.12.17
 * Time: 14:27
 */

namespace App\Infrastructure\Domain\Repository\BankAccount;

use App\Domain\Client\BankAccount\BankAccount;
use App\Domain\Client\BankAccount\BankAccountRepositoryInterface;
use App\Domain\Client\BankAccount\Exception\BankAccountNotFoundException;
use App\Infrastructure\DoctrineRepositoryAbstract;
use Ramsey\Uuid\UuidInterface;

class BankAccountRepository extends DoctrineRepositoryAbstract implements BankAccountRepositoryInterface
{
    public function add(BankAccount $bankAccount): void
    {
        $this->entityManager->persist($bankAccount);
        $this->entityManager->flush();
    }

    public function getById(UuidInterface $id): BankAccount
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

    public function remove(BankAccount $bankAccount): void
    {
        $this->entityManager->remove($bankAccount);
    }

    public function contains(BankAccount $bankAccount): bool
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