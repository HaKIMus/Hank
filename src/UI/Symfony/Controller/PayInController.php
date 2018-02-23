<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Application\Authorization\Exception\ClientNotSignedIn;
use Hank\Application\Command\PayInCommand;
use Hank\Application\Handler\PayInHandler;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\PayInDbalAdapter;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\PayOutDbalAdapter;
use Hank\Infrastructure\Domain\Adapters\LoggingSystem\DbalPayInLogSystemAdapter;
use Hank\Infrastructure\Domain\Repository\BankAccountRepository;
use Hank\Infrastructure\Domain\Repository\ClientRepository;
use Hank\Infrastructure\Domain\Repository\LogRepository;
use Hank\Infrastructure\Service\ClientService;
use Hank\Infrastructure\Service\UpdateClientSessionService;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayInController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(): Response
    {
        try {
            return $this->render('panel/pay-in-client-panel.twig', [
                'client' => $this->clientService->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->redirectToRoute('app_bank_sign_in')
                ->setStatusCode(401);
        }
    }

    public function payIn(Request $request, UpdateClientSessionService $updateClientSessionService, LogRepository $logRepository): Response
    {
        $clientId = Uuid::fromString($this->clientService->getClient()->id());

        $bankAccountId = Uuid::fromString($this->clientService->getClient()->getBankAccount()->id())->toString();

        /** @var Connection $connection */
        $connection = $this->getDoctrine()->getConnection();

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $payInCommand = new PayInCommand(
            $request->get('amount'),
            $bankAccountId,
            $clientId
        );

        $payInHandler = new PayInHandler(
            new BankAccountRepository($connection, $entityManager),
            new PayInDbalAdapter($connection),
            $logRepository
        );

        $payInHandler->handle($payInCommand);

        $updateClientSessionService->update();


        return $this->redirectToRoute('app_bank_pay_in_client_panel');
    }
}