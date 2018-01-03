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
use App\Infrastructure\Domain\Adapters\Db\Dbal\ClientDbalAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class HankController extends Controller
{
    protected function getClient(): ClientView
    {
        /** @var Session $session */
        $session = $this->get('session');

        if ($session->has('client')) {
            /**
             * @Todo This piece of code shouldn't be here!
             */
            $client = new ClientDbalAdapter($this->getDoctrine()->getConnection());

            $session->set('client', $client->getByClientName($session->get('client')->getName()));

            $client = $session->get('client');

            return $client;
        }

        throw new ClientNotSignedIn();
    }
}