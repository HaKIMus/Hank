<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\SignOut as SignOutApplication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SignOutController extends Controller
{
    public function index(SessionInterface $session): Response
    {
        $signOut = new SignOutApplication($session);

        $signOut->execute();

        return $this->render('authorization/sign-in.twig')
            ->setStatusCode(200);
    }
}