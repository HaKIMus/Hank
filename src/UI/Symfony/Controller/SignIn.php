<?php

namespace App\UI\Symfony\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SignIn extends Controller
{
    public function index(): Response
    {
        return $this->render('authorization/sign-in.twig');
    }
}