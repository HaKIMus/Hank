<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\SignIn as AuthorizationSignIn;
use App\Infrastructure\Domain\Adapters\Db\Dbal\ClientDbalAdapter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Ramsey\Uuid\Uuid;
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
        $session = $this->container->get('session');

        $name = $request->get('name');
        $password = $request->get('password');

        $clientDbal = new ClientDbalAdapter(new Connection($connParams, new Driver()));

        $authorization = new AuthorizationSignIn(
            $name,
            $password,
            $clientDbal,
            $session
        );

        if ($authorization->validateData()) {
            $authorization->setClientSession();

            return $this->redirectToRoute('app_bank_client_panel');
        }

        return $this->redirectToRoute('app_bank_sign_in');
    }
}