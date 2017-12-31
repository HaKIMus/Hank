<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use Symfony\Component\HttpFoundation\Response;

class BankHomePage extends HankController
{
    public function index(): Response
    {
        try {
            return $this->render('main/homepage.twig', [
                'client' => $this->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->render('main/homepage.twig');
        }
    }
}