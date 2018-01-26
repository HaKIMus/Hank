<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use App\Infrastructure\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ClientPanelController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(): Response
    {
        try {
            return $this->render('panel/client-panel.twig', [
                'client' => $this->clientService->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->redirectToRoute('app_bank_sign_in')
                ->setStatusCode(401);
        }
    }
}