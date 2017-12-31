<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 30.12.17
 * Time: 02:58
 */

namespace App\UI\Symfony\Controller;


use App\Application\Authorization\Exception\ClientNotSignedIn;
use Symfony\Component\HttpFoundation\Response;

class PayIn extends HankController
{
    public function index(): Response
    {
        try {
            return $this->render('panel/pay-in-client-panel.twig', [
                'client' => $this->getClient()
            ]);
        } catch (ClientNotSignedIn $e) {
            return $this->redirectToRoute('app_bank_sign_in')
                ->setStatusCode(401);
        }
    }
}