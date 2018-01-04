<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 30.12.17
 * Time: 02:58
 */

namespace App\UI\Symfony\Controller;


use App\Application\Authorization\Exception\ClientNotSignedIn;
use App\Application\Command\BankAccount\PayInCommand;
use App\Application\Command\BankAccount\PayInHandler;
use App\Infrastructure\Domain\Adapters\Db\Dbal\BankAccountDbalAdapter;
use App\Infrastructure\Domain\Repository\BankAccount\BankAccountRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PayIn extends HankController
{
    public function index(): Response
    {
        try {
            return $this->render('panel/pay-in-client-panel.twig', [
                'client' => $this->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->redirectToRoute('app_bank_sign_in')
                ->setStatusCode(401);
        }
    }

    public function payIn(Request $request): Response
    {
        $payInCommand = new PayInCommand(
            Uuid::fromString($this->getClient()->getBankAccount()->id())->toString(),
            $request->get('amount')
        );

        $payInHandler = new PayInHandler(
            new BankAccountRepository($this->getDoctrine()->getConnection(), $this->getDoctrine()->getManager()),
            new BankAccountDbalAdapter($this->getDoctrine()->getConnection())
        );

        $payInHandler->handle($payInCommand);

        return $this->render('panel/pay-in-client-panel.twig', [
            'client' => $this->getClient()
        ]);
    }
}