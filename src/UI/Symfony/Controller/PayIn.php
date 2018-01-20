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
use App\Infrastructure\Domain\Repository\BankAccount\BankAccountRepository;
use App\Infrastructure\Service\ClientService;
use App\Infrastructure\Service\UpdateClientSessionService;
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
        $payInCommand = new PayInCommand(
            Uuid::fromString($this->clientService->getClient()->getBankAccount()->id())->toString(),
            $request->get('amount')
        );

        $payInHandler = new PayInHandler(
            new BankAccountRepository($this->getDoctrine()->getConnection(), $this->getDoctrine()->getManager()),
            new BankAccountDbalAdapter($this->getDoctrine()->getConnection())
        );

        $payInHandler->handle($payInCommand);

        $updateClientSessionService->update();

        return $this->redirectToRoute('app_bank_pay_in_client_panel');
    }
}