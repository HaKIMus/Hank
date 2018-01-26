<?php

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use App\Application\Authorization\SignOut as SignOutApplication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SignOutController extends Controller
{
    public function index(): Response
    {
        $signOut = new SignOutApplication($this->get('session'));

        try {
            $signOut->execute();
        } catch (ClientNotSignedIn $e) {
            return $this->render('authorization/sign-in.twig')
                ->setStatusCode(401);
        }

        return $this->render('authorization/sign-in.twig')
            ->setStatusCode(200);
    }
}