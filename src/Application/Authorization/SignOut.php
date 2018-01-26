<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 10.12.17
 * Time: 16:54
 */

namespace App\Application\Authorization;

use App\Application\Authorization\Exception\ClientNotSignedIn;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SignOut
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function execute(): void
    {
        if ($this->session->has('client')) {
            $this->session->remove('client');
        }
    }
}