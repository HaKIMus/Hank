<?php

namespace Hank\UI\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Hank\Application\Command\PayOutCommand;
use Hank\Application\Handler\PayOutHandler;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\PayOutDbalAdapter;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayOutController extends Controller
{
    public function index(): Response
    {
        return $this->render('panel/pay-out-client-panel.twig');
    }

    public function payOut(
        Request $request,
        LogRepository $logRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $clientId = $this->getUser()->getId()->toString();
        $bankAccountId = Uuid::fromString($this->getUser()->getBankAccount()->getId())->toString();

        $payOutCommand = new PayOutCommand(
            $request->get('amount'),
            $bankAccountId,
            $clientId
        );

        $payOutHandler = new PayOutHandler(
            new BankAccountRepository($entityManager->getConnection(), $entityManager),
            new PayOutDbalAdapter($entityManager->getConnection()),
            $logRepository
        );

        $entityManager->commit();

        try {
            $payOutHandler->handle($payOutCommand);
        } catch (\Exception $exception) {
            return $this->redirectToRoute('app_bank_pay_out_client_panel');
        }

        return $this->redirectToRoute('app_bank_pay_out_client_panel');
    }
}