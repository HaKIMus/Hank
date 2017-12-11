<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\SignIn as AuthorizationSignIn;
use App\Domain\Client\Client;
use App\Domain\Client\Email;
use App\Domain\Client\Password;
use App\Domain\Client\Username;
use App\Infrastructure\Domain\Dbal\Client\ClientDbal;
use App\Infrastructure\Domain\Repository\Client\ClientRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
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

        $authorization = new AuthorizationSignIn(
            $request->get('username'),
            $request->get('password'),
            new ClientDbal(new Connection($connParams, new Driver())),
            $session
        );

        if ($authorization->signIn()) {
            return $this->redirectToRoute('app_bank_client_panel');
        }

        return $this->redirectToRoute('app_bank_sign_in');
    }
}