<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 20.01.18
 * Time: 11:13
 */

namespace App\Infrastructure\Service;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use App\Application\Query\View\Client\ClientView;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class ClientService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getClient(): ClientView
    {
        if ($this->session->has('client')) {
            return $this->session->get('client');
        }

        throw new ClientNotSignedIn();
    }
}