<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 17.12.17
 * Time: 14:25
 */

namespace App\UI\Symfony\Controller;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use App\Application\Query\View\Client\ClientView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class HankController extends Controller
{
    protected function getClient(): ClientView
    {
        /** @var Session $session */
        $session = $this->get('session');

        if ($session->has('client')) {
            $client = $session->get('client');

            return $client;
        }

        throw new ClientNotSignedIn();
    }
}