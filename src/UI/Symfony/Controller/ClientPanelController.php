<?php

namespace Hank\UI\Symfony\Controller;

use Hank\Infrastructure\Service\ChangeAvatarService;
use Hank\Infrastructure\Service\ChangeBackgroundService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ClientPanelController extends Controller
{
    public function index(FlashBagInterface $flashBag): Response
    {
        if ($flashBag->has('error')) {
            $error = $flashBag->get('error');
        } else {
            $error = null;
        }

        return $this->render('panel/client-panel.twig', [
            'errors' => $error
        ]);
    }

    public function changeClintBackground(
        Request $request,
        ChangeBackgroundService $changeBackgroundService,
        FlashBagInterface $flashBag
    ): Response {
        try {
            $changeBackgroundService->change($request->get('url'), $this->getUser()->getId());
        } catch (\Exception $exception) {
            $flashBag->add('error', 'The URL is not an image!');

            return $this->redirectToRoute('hank_client_panel');
        }

        return $this->redirectToRoute('hank_client_panel');
    }

    public function changeClientAvatar(
        Request $request,
        ChangeAvatarService $changeAvatarService,
        FlashBagInterface $flashBag
    ): Response {
        try {
            $changeAvatarService->change($request->get('url'), $this->getUser()->getId());
        } catch (\Exception $exception) {
            $flashBag->add('error', 'The URL is not an image!');

            return $this->redirectToRoute('hank_client_panel');
        }

        return $this->redirectToRoute('hank_client_panel');
    }
}