<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Infrastructure\Service\ChangeBackgroundService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientPanelController extends Controller
{
    public function index(): Response
    {
        return $this->render('panel/client-panel.twig', [
            'changeBackgroundError' => $this->get('session')->getFlashBag()->get('changeBackgroundError')
        ]);
    }

    public function changeClintBackground(Request $request, ChangeBackgroundService $changeBackgroundService): Response
    {
        try {
            $changeBackgroundService->change($request->get('url'), $this->getUser()->getId());
        } catch (\Exception $exception) {
            $this->get('session')->getFlashBag()->add('changeBackgroundError', 'The URL is not an image!');

            return $this->redirectToRoute('app_bank_client_panel');
        }

        return $this->redirectToRoute('app_bank_client_panel');
    }
}