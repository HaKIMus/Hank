<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Application\Authorization\SignIn as AuthorizationSignIn;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\ClientDbalAdapter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SignInController extends Controller
{
    public function index(): Response
    {
        return $this->render('authorization/sign-in.twig');
    }

    public function signIn(Request $request, SessionInterface $session, ClientDbalAdapter $clientDbal): Response
    {
        $name = $request->get('name');
        $password = $request->get('password');

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