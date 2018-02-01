<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Application\Authorization\Exception\ClientNotSignedIn;
use Hank\Infrastructure\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BankHomePageController extends Controller
{
    private $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(): Response
    {
        try {
            return $this->render('main/homepage.twig', [
                'client' => $this->clientService->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->render('main/homepage.twig');
        }
    }
}