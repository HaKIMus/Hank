<?php

namespace App\UI\Symfony\Controller;

use App\Application\Command\CreateNewClientCommand;
use App\Application\Handler\CreateNewClientHandler;
use App\Infrastructure\Domain\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SignUpController extends Controller
{
    public function index(): Response
    {
        return $this->render('authorization/sign-up.twig');
    }

    public function signUp(Request $request, ClientRepository $clientRepository): Response
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        $signUpCommand = new CreateNewClientCommand(
            $name,
            $password,
            $email
        );

        $signUpHandler = new CreateNewClientHandler($clientRepository);

        $signUpHandler->handle($signUpCommand);

        return $this->redirectToRoute('app_bank_sign_in');
    }
}