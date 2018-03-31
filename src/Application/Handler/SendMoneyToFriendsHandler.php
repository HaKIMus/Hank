<?php

namespace Hank\Application\Handler;

use Hank\Application\Command\SendMoneyToFriendsCommand;
use Hank\Domain\BankAccount\BankAccount;
use Hank\Domain\Client\Email;
use Hank\Domain\Ports;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Ramsey\Uuid\Uuid;

class SendMoneyToFriendsHandler implements  HandlerInterface
{
    private $bankAccountRepository;
    private $sendingMoneyToFriend;

    public function __construct(
        BankAccountRepository $bankAccountRepository,
        Ports\SendingMoneyToFriend $sendingMoneyToFriend
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->sendingMoneyToFriend = $sendingMoneyToFriend;
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
            $this->sendingMoneyToFriend
        );
    }
}