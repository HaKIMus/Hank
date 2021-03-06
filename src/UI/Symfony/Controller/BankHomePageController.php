<?php

namespace Hank\UI\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BankHomePageController extends Controller
{
    public function index(): Response
    {
        return $this->render('main/homepage.twig');
    }
}