<?php

namespace Hank\UI\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Hank\Application\Command\PayInCommand;
use Hank\Application\Handler\PayInHandler;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\PayInDbalAdapter;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayInController extends Controller
{
    public function index(): Response
    {
        return $this->render('panel/pay-in-client-panel.twig');
    }

    public function payIn(
        Request $request,
        LogRepository $logRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $clientId = Uuid::fromString($this->getUser()->getId()->toString());

        $bankAccountId = Uuid::fromString($this->getUser()->getBankAccount()->getId())->toString();

        $payInCommand = new PayInCommand(
            $request->get('amount'),
            $bankAccountId,
            $clientId
        );

        $payInHandler = new PayInHandler(
            new BankAccountRepository($entityManager->getConnection(), $entityManager),
            new PayInDbalAdapter($entityManager->getConnection()),
            $logRepository
        );

        $entityManager->commit();

        try {
            $payInHandler->handle($payInCommand);
        } catch (\Exception $exception) {
            return $this->redirectToRoute('hank_pay_in_client_panel', [], 403);
        }

        return $this->redirectToRoute('hank_pay_in_client_panel');
    }
}