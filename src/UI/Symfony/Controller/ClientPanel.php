<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use Symfony\Component\HttpFoundation\Response;

class ClientPanel extends HankController
{
    public function index(): Response
    {
        try {
            return $this->render('panel/client-panel.twig', [
                'client' => $this->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->redirectToRoute('app_bank_sign_in')
                ->setStatusCode(401);
        }
    }
}