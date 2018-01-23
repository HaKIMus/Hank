<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 30.12.17
 * Time: 02:58
 */

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use App\Application\Command\PayInCommand;
use App\Application\Handler\PayInHandler;
use App\Infrastructure\Domain\Adapters\Db\Dbal\BankAccountDbalAdapter;
use App\Infrastructure\Domain\Adapters\LoggingSystem\DbalPayInLogSystemAdapter;
use App\Infrastructure\Domain\Repository\BankAccount\BankAccountRepository;
use App\Infrastructure\Service\ClientService;
use App\Infrastructure\Service\UpdateClientSessionService;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayIn extends Controller
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

    public function payIn(Request $request, UpdateClientSessionService $updateClientSessionService): Response
    {
        $clientId = Uuid::fromString($this->clientService->getClient()->id());

        $bankAccountId = Uuid::fromString($this->clientService->getClient()->getBankAccount()->id())->toString();

        /** @var Connection $connection */
        $connection = $this->getDoctrine()->getConnection();

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $payInCommand = new PayInCommand(
            $bankAccountId,
            $request->get('amount')
        );

        $payInHandler = new PayInHandler(
            new BankAccountRepository($connection, $entityManager),
            new BankAccountDbalAdapter($connection),
            new DbalPayInLogSystemAdapter($bankAccountId, $clientId, $connection)
        );

        $payInHandler->handle($payInCommand);

        $updateClientSessionService->update();

        return $this->redirectToRoute('app_bank_pay_in_client_panel');
    }
}