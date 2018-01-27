<?php

namespace Hank\Application\Authorization;

use Hank\Application\Authorization\Exception\ClientNotSignedIn;
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