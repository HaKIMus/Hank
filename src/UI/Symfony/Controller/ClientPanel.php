<?php

namespace App\UI\Symfony\Controller;

use App\Application\Query\View\Client\ClientView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ClientPanel extends Controller
{
    public function index(): Response
    {
        return $this->render('panel/client-panel.twig', [
            'client' => $this->getClient()
        ]);
    }

    private function getClient(): ClientView
    {
        return $this->container->get('session')
            ->get('client');
    }
}