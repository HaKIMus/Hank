<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Application\Command\SendMoneyToFriendsCommand;
use Hank\Application\Handler\SendMoneyToFriendsHandler;
use Hank\Domain\Ports\PayOut;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\PayOutDbalAdapter;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\SendingMoneyToFriendAdapter;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendMoneyToFriendsController extends Controller
{
    public function index(): Response
    {
        return $this->render('panel/send-money-to-friends-client-panel.twig');
    }

    public function send(
        Request $request,
        BankAccountRepository $bankAccountRepository,
        SendingMoneyToFriendAdapter $sendingMoneyToFriendAdapter
    ): Response {
        $amount = $request->get('amount');
        $email = $request->get('email');
        $clientId = $this->getUser()->getId();
        $bankAccountId = $this->getUser()->getBankAccount()->getId();

        $sendMoneyHandler = new SendMoneyToFriendsHandler($bankAccountRepository, $sendingMoneyToFriendAdapter);

        $sendMoneyHandler->handle(new SendMoneyToFriendsCommand($amount, $email, $bankAccountId, $clientId));

        $bankAccountRepository->commit();

        return $this->redirectToRoute('hank_send_money_to_friends');
    }
}