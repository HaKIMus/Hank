<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Application\Command\CreateNewClientCommand;
use Hank\Application\Handler\CreateNewClientHandler;
use Hank\Infrastructure\Domain\Repository\ClientRepository;
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

        $submittedToken = $request->request->get('_csrf_token');

        if ($this->isCsrfTokenValid('authenticate', $submittedToken)) {
            $signUpCommand = new CreateNewClientCommand(
                $name,
                $password,
                $email
            );

            $signUpHandler = new CreateNewClientHandler($clientRepository);
            $signUpHandler->handle($signUpCommand);

            return $this->redirectToRoute('hank_sign_in');
        }

        return $this->redirectToRoute('hank_sign_in');
    }
}