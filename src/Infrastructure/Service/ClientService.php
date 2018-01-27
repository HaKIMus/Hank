<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 20.01.18
 * Time: 11:13
 */

namespace Hank\Infrastructure\Service;

use Hank\Application\Authorization\Exception\ClientNotSignedIn;
use Hank\Application\Query\View\Client\ClientView;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class ClientService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @throws ClientNotSignedIn
     */
    public function getClient(): ClientView
    {
        if ($this->session->has('client')) {
            return $this->session->get('client');
        }

        throw new ClientNotSignedIn();
    }
}