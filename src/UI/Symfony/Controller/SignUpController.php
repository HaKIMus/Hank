<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\SignIn as AuthorizationSignIn;
use App\Infrastructure\Domain\Adapters\Db\Dbal\ClientDbalAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SignUpController extends Controller
{
    public function index(): Response
    {
        return $this->render('authorization/sign-up.twig');
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