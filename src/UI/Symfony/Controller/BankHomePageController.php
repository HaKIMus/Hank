<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Application\Authorization\Exception\ClientNotSignedIn;
use Hank\Infrastructure\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BankHomePageController extends Controller
{
    public function index(): Response
    {
        return $this->render('main/homepage.twig');
    }
}