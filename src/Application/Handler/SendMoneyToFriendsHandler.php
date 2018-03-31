<?php

namespace Hank\Application\Handler;

use Hank\Application\Command\SendMoneyToFriendsCommand;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Client\Email;
use Hank\Domain\Ports;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class SendMoneyToFriendsHandler implements  HandlerInterface
{
    private $bankAccountRepository;
    private $sendingMoneyToFriend;
    private $logRepository;
    private $clientId;

    public function __construct(
        BankAccountRepository $bankAccountRepository,
        Ports\SendingMoneyToFriend $sendingMoneyToFriend,
        LogRepository $logRepository,
        UuidInterface $clientId
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->sendingMoneyToFriend = $sendingMoneyToFriend;
        $this->logRepository = $logRepository;
        $this->clientId = $clientId;
    }

    /**
     * @param SendMoneyToFriendsCommand $command
     */
    public function handle(object $command): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccountRepository
            ->getById(Uuid::fromString($command->getBankAccountId()));

        $bankAccount->sendMoneyToFriend(
            $command->getAmount(),
            new Email($command->getEmail()),
            $this->sendingMoneyToFriend,
            $this->logRepository,
            $this->clientId
        );
    }
}