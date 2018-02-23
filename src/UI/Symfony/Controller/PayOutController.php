<?php

namespace Hank\UI\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Hank\Application\Authorization\Exception\ClientNotSignedIn;
use Hank\Application\Command\PayOutCommand;
use Hank\Application\Handler\PayOutHandler;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\PayOutDbalAdapter;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Hank\Infrastructure\Service\ClientService;
use Hank\Infrastructure\Service\UpdateClientSessionService;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayOutController extends Controller
{
    public function index(ClientService $clientService): Response
    {
        try {
            return $this->render('panel/pay-out-client-panel.twig', [
                'client' => $clientService->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->redirectToRoute('app_bank_sign_out')
                ->setStatusCode(401);
        }
    }

    public function payOut(
        Request $request,
        UpdateClientSessionService $updateClientSessionService,
        ClientService $clientService,
        LogRepository $logRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $clientId = $clientService->getClient()->id();
        $bankAccountId = Uuid::fromString($clientService->getClient()->getBankAccount()->id())->toString();

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
            return $this->redirectToRoute('app_bank_pay_out_client_panel', [], 403);
        }

        $updateClientSessionService->update();

        return $this->redirectToRoute('app_bank_pay_out_client_panel');
    }
}