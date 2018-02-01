<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Application\Authorization\Exception\ClientNotSignedIn;
use Hank\Application\Command\PayInCommand;
use Hank\Application\Command\PayOutCommand;
use Hank\Application\Handler\PayInHandler;
use Hank\Application\Handler\PayOutHandler;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\PayOutDbalAdapter;
use Hank\Infrastructure\Domain\Adapters\LoggingSystem\DbalPayInLogSystemAdapter;
use Hank\Infrastructure\Domain\Adapters\LoggingSystem\DbalPayOutLogSystemAdapter;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Service\ClientService;
use Hank\Infrastructure\Service\UpdateClientSessionService;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
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

    public function payOut(Request $request, UpdateClientSessionService $updateClientSessionService, ClientService $clientService): Response
    {
        $clientId = $clientService->getClient()->id();
        $bankAccountId = Uuid::fromString($clientService->getClient()->getBankAccount()->id())->toString();

        /** @var Connection $connection */
        $connection = $this->getDoctrine()->getConnection();

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $payOutCommand = new PayOutCommand(
            $bankAccountId,
            $request->get('amount')
        );

        $payOutHandler = new PayOutHandler(
            new BankAccountRepository($connection, $entityManager),
            new PayOutDbalAdapter($connection),
            new DbalPayOutLogSystemAdapter($bankAccountId, $clientId, $connection)
        );

        $payOutHandler->handle($payOutCommand);

        $updateClientSessionService->update();

        return $this->redirectToRoute('app_bank_pay_out_client_panel');
    }
}