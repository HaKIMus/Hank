<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\SignIn as AuthorizationSignIn;
use App\Infrastructure\Domain\Dbal\Client\ClientDbal;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignIn extends Controller
{
    public function index(): Response
    {
        return $this->render('authorization/sign-in.twig');
    }

    public function signIn(Request $request): Response
    {
        $connParams = $this->container->getParameter('connection');

        $authorization = new AuthorizationSignIn(
            $request->get('username'),
            $request->get('password'),
            new ClientDbal(new Connection($connParams, new Driver()))
        );

        if ($authorization->signIn()) {
            return $this->redirectToRoute('admin');
        }

        return $this->redirectToRoute('app_bank_sign_in');
    }
}